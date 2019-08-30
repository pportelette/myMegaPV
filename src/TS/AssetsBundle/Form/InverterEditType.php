<?php

namespace TS\AssetsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TS\AssetsBundle\Entity\Substation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InverterEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'disabled'  => 'disabled'
            ))
            ->add('brand', TextType::class, array(
                'disabled'  => 'disabled'
            ))
            ->add('model', TextType::class, array(
                'disabled'  => 'disabled'
            ))
            ->add('power', TextType::class, array(
                'disabled'  => 'disabled'
            ))
            ->add('Save', SubmitType::class, array(
                'disabled'  => 'disabled'
            ));
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
