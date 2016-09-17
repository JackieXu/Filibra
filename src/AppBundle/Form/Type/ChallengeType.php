<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ChallengeType
 *
 * @package AppBundle\Form\Type
 */
class ChallengeType extends AbstractType
{
    /**
     * Builds ChallengeType form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('prize', IntegerType::class)
            ->add('hashTag', TextType::class)
            ->add('startDate', DateTimeType::class)
            ->add('finishDate', DateTimeType::class)
            ->add('sponsorName', TextType::class)
            ->add('sponsorImageURL', TextType::class)
            ->add('sponsorWebsiteURL', TextType::class)
            ->add('users')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Challenge'
        ));
    }
}
