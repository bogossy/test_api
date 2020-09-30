<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[ 'class'=>'form-control']
            ])
            ->add('datedebut',DateTimeType::class, [
                'label' =>'Date de début ',
                'widget' => 'single_text',

                ])
            ->add('datefin',DateTimeType::class, [
                'label' =>'Date de fin ',
                'widget' => 'single_text',

            ])
           // ->add('datecreation')
            ->add('capaciteaccueil',NumberType::class,[
                 'label' =>'Place total disponible ',
                 'attr'=>[ 'class'=>'form-control']
                 ])
           // ->add('status')
           ->add('creer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }

}
