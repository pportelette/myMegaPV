<?php

namespace TS\RegisterBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate',      DateTimeType::class)
            ->add('endDate',        DateTimeType::class)
            ->add('siteName',       TextType::class)
            ->add('origin',         TextType::class)
            ->add('consequence',    TextType::class)
            ->add('substation',     TextType::class)
            ->add('equipement',     TextType::class)
            ->add('ensOperator',    NumberType::class)
            ->add('ensOther',       NumberType::class)
            ->add('coment',         TextareaType::class)
            ->add('Enregistrer',    SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\RegisterBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ts_registerbundle_event';
    }


}
