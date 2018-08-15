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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use TS\RegisterBundle\Entity\Event;
use TS\AssetsBundle\Repository\SubstationRepository;
use TS\AssetsBundle\Repository\EquipmentRepository;

class EventType extends AbstractType
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
            ->add('site',           EntityType::class, array(
                'class'         =>  'TSAssetsBundle:Site',
                'placeholder'   =>  ' ',
                'choice_label'  =>  'siteName'
            ))
            ->add('substation',     EntityType::class, array(
                'class' => 'TSAssetsBundle:Substation',
                'placeholder' => ' ',
                'choice_label' => 'name',
            ))
            ->add('origin',         TextType::class)
            ->add('consequence',    TextType::class)
            ->add('equipment',      EntityType::class, array(
                'class' => 'TSAssetsBundle:Equipment',
                'placeholder' => ' ',
                'choice_label' => 'name',
            ))
            ->add('ensOperator',    NumberType::class)
            ->add('ensOther',       NumberType::class)
            ->add('coment',         TextareaType::class)
            ->add('Enregistrer',    SubmitType::class)
        ;
        
        $formSubModifier = function (FormInterface $form, $siteId) {
            $form->add('substation', EntityType::class, array(
                'class' => 'TSAssetsBundle:Substation',
                'placeholder' => ' ',
                'query_builder' => function (SubstationRepository $repository) use ($siteId) {
                    return $repository->getQuerySubstations($siteId);
                }
            ));    
        };

        $formEquModifier = function (FormInterface $form, $subId) {
            $form->add('equipment', EntityType::class, array(
                'class' => 'TSAssetsBundle:Equipment',
                'placeholder' => ' ',
                'query_builder' => function (EquipmentRepository $repository) use ($subId) {
                    return $repository->getQueryEquipments($subId);
                }
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formSubModifier, $formEquModifier, $em) {
                $data = $event->getData();
                $site = $data->getSite();
                $siteId = $site ? $site->getId() : null;
                $substation = $data->getSubstation();
                $subId = $substation ? $substation->getId() : null;
                $equipment = $data->getEquipment();
                
                $form = $event->getForm();

                if($site) {
                    $equipmentClass = get_class($equipment);
                    $form
                        ->add('site',     EntityType::class, array(
                            'class'         =>  'TSAssetsBundle:Site',
                            'placeholder'   =>  ' ',
                            'choice_label'  =>  'siteName',
                            'data'          =>  $em->getReference("TSAssetsBundle:Site", $site)
                        ))
                        ->add('substation', EntityType::class, array(
                            'class'         => 'TSAssetsBundle:Substation',
                            'placeholder'   => ' ',
                            'query_builder' => function (SubstationRepository $repository) use ($siteId) {
                                return $repository->getQuerySubstations($siteId);
                            },
                            'data'          => $em->getReference("TSAssetsBundle:Substation", $substation)
                        ))
                        ->add('equipment', EntityType::class, array(
                            'class'         => 'TSAssetsBundle:Equipment',
                            'placeholder'   => ' ',
                            'query_builder' => function (EquipmentRepository $repository) use ($subId) {
                                return $repository->getQueryEquipments($subId);
                            },
                            'data'          => $em->getReference($equipmentClass, $equipment)
                        ))
                    ;
                    
                }else {
                    $formSubModifier($form, $siteId);
                    $formEquModifier($form, $subId);
                }
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formSubModifier, $formEquModifier) {
                $data = $event->getData();
                $site = $data['site'];
                $substation = $data['substation'];
                $form = $event->getForm();
                $formSubModifier($form, $site, 0);
                $formEquModifier($form, $substation);
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
