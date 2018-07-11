<?php

namespace TS\DataManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ImportDataRawType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',           DateTimeType::class)
            ->add('energyInjected', NumberType::class)
            ->add('irradiation',    NumberType::class)
            ->add('site',           EntityType::class, array(
                'class'         =>  'TSAssetsBundle:Site',
                'choice_label'  =>  'siteName'
            ))
            ->add('Enregistrer',    SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\DataManagerBundle\Entity\ImportDataRaw'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ts_datamanagerbundle_importdataraw';
    }


}
