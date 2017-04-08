<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class FillingTypeProfile
 */
class FillingTypeProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profile_id', 'integer')
            ->add('is_default', 'checkbox', array(
                'required' => false,
            ))
            ->add('pricing_grids')
            ->add('pricing_equation_params')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\FillingTypeProfile',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return '';
    }
}
