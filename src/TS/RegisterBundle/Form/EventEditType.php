<?php

namespace TS\RegisterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use TS\RegisterBundle\Entity\Event;
use TS\AssetsBundle\Repository\SiteRepository;
use TS\AssetsBundle\Repository\SubstationRepository;
use TS\AssetsBundle\Repository\EquipmentRepository;

class EventEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $em = $options['em'];
        $builder
            ->add('startDate',      DateTimeType::class)
            ->add('endDate',        DateTimeType::class)
            ->add('origin',         TextType::class)
            ->add('consequence',    TextType::class)
            ->add('ensOperator',    NumberType::class)
            ->add('ensOther',       NumberType::class)
            ->add('coment',         TextareaType::class)
            ->add('Enregistrer',    SubmitType::class)
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($em) {
                $data = $event->getData();
                $site = $data->getSite();
                $siteId = $site ? $site->getId() : null;
                $substation = $data->getSubstation();
                $subId = $substation ? $substation->getId() : null;
                $equipment = $data->getEquipment();
                $equId = $equipment ? $equipment->getId() : null;
                
                $form = $event->getForm();

                $equipmentClass = get_class($equipment);
                $form
                    ->add('site',     ChoiceType::class, array(
                        'choices'       =>  [$em->getReference("TSAssetsBundle:Site", $siteId)],
                        'choice_label'  =>  'siteName',
                    ))
                    ->add('substation', ChoiceType::class, array(
                        'choices'         => [$em->getReference("TSAssetsBundle:Substation", $subId)],
                        'choice_label'  =>  'name',
                    ))
                    ->add('equipment', EntityType::class, array(
                        'class'         => 'TSAssetsBundle:Equipment',
                        'placeholder'   => ' ',
                        'query_builder' => function (EquipmentRepository $repository) use ($subId) {
                            return $repository->getQueryEquipments($subId);
                        },
                        'data'          => $em->getReference($equipmentClass, $equId)
                    ))
                ;
            }
        );

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class
        ));
        $resolver->setRequired('em');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ts_registerbundle_event';
    }


}
