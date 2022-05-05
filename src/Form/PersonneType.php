<?php

namespace App\Form;

use App\Entity\Hobby;
use App\Entity\Personne;
use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('name')
            ->add('age')
            ->add('createdAt')
            ->add('job')
            ->add('hobbies',EntityType::class,['expanded'=>false,
                'multiple'=>true,
                'class'=>Hobby::class,
                'query_builder'=>function (EntityRepository $er){
                return $er->createQueryBuilder('h')
                ->orderBy('h.name','ASC');
                },
                'choice_label'=>'name'
            ])
            ->add('profile',EntityType::class,['expanded'=>true,'multiple'=>false,'class'=>Profile::class])
            ->add('editer',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
