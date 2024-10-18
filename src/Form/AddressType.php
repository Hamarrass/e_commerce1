<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Country;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class)
            ->add('firstname',TextType::class)
            ->add('lastname',TextType::class)
            ->add('company',TextType::class)
            ->add('address',TextType::class,[
                'required'=>false
            ])
            ->add('codePostal',TextType::class)
            ->add('city',TextType::class)
            ->add('country',CountryType::class,[
                'placeholder'=>'Choisir votre pays'
            ])
            ->add('phone',TextType::class)
            ->add('submit',SubmitType::class,[
                'label' => 'Valider',
                'attr'  => [
                    'class'=> 'btn btn-info w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
