<?php

namespace App\Form;

use App\Entity\Address;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
       $user = $options['user'];

        $builder
            ->add('adressess', EntityType::class, [
                'label' => 'Choisissez votre adresse de livraison',
                'required' => true,
                'class' => Address::class,
                'multiple' => false,
                'expanded' => true,
                'query_builder' => function(EntityRepository $er) use ($user) {

                    return $er->createQueryBuilder('a')
                              ->andWhere('a.user=  :user')
                              ->setParameter('user',$user->getId())
                              ->andWhere('a.isDeleted = false') ;

                }
                // 'choice_label' => 'Address'
                // 'choices' => $user->getAddresses()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
              'user' =>array()
        ]);
    }
}
