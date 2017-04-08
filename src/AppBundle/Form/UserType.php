<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class UserType extends AbstractType
{

    CONST ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    CONST ROLE_USER = 'ROLE_USER';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username');
        $builder->add('password', 'password');
        $builder->add('passwordConfirm', 'password', array('label' => 'Confirm Password'));
        $builder->add('email');
        $builder->add('firstname', 'text', array('label' => 'First Name'));
        $builder->add('lastname', 'text', array('label' => 'Last Name'));
        $builder->add('roles', 'choice', array(
            'multiple' => true,
            'choices' => array(
                self::ROLE_USER => 'User',
                self::ROLE_SUPER_ADMIN => 'Admin'
            )
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'users';
    }
}
