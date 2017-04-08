<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BinaryFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name");
        $builder->add("description");
        $builder->add("contentType");
        $builder->add("size");
        $builder->add("filesystemAdapter");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\BinaryFile',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'binary_file';
    }
}
