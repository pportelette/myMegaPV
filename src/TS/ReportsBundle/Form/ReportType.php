<?php

namespace TS\ReportsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ReportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('site', EntityType::class, array(
                'class'        => 'TSAssetsBundle:Site',
                'choice_label' => 'siteName',
                'multiple'    => false,
                'expanded' => false
            ))
            ->add('startDate',  DateType::class, array(
                'widget' => 'single_text'
            ))
            ->add('endDate',    DateType::class, array(
                'widget' => 'single_text'
            ))
            ->add('register',   CheckboxType::class, array('required' => false))
            ->add('rows',   CheckboxType::class, array('required' => false))
            ->add('curve',       CheckboxType::class, array('required' => false))
            ->add('generate',     SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TS\ReportsBundle\Entity\Report'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_search';
    }


}
