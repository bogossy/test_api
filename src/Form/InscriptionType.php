<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr'=>[ 'class'=>'form-control']
            ])
            ->add('prenom',TextType::class,[
                'attr'=>[ 'class'=>'form-control']
            ])
            ->add('email', EmailType::class,[
                'attr'=>[ 'class'=>'form-control']
            ])
            ->add('telephone',TelType::class,[
                'attr'=>[ 'placeholder' => 'ex: 0707000000','class'=>'form-control']
            ])

            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
