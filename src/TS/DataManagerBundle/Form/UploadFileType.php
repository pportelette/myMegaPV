<?php
namespace TS\DataManagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UploadFileType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('site', EntityType::class, array(
        'class'        => 'TSAssetsBundle:Site',
        'choice_label' => 'siteName'
    ))
      ->add('file',     FileType::class)
      ->add('Open',   SubmitType::class)
    ;
  }
}