<?php

namespace TS\AssetsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\AssetsBundle\Entity\Substation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class InverterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('brand')
            ->add('model')
            ->add('power')
            ->add('substation', EntityType::class, array(
                'class'         =>  'TSAssetsBundle:Substation',
                'placeholder'   =>  ' ',
                'choice_label'  =>  'name'
            ))
            ->add('Enregistrer',    SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\AssetsBundle\Entity\Inverter'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ts_assetsbundle_inverter';
    }


}
