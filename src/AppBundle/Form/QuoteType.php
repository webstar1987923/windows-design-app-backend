<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class QuoteType
 */
class QuoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name");
        $builder->add("revision");
        $builder->add("date");
        $builder->add("position");
        $builder->add('units', 'collection', [
            'type'      => new UnitType($options['entity_manager']),
            'allow_add' => true,
            'mapped'    => false,
        ]);
        $builder->add('accessories', 'collection', [
            'type'      => new AccessoryType(),
            'allow_add' => true,
            'mapped'    => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');

        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\Quote',
            'csrf_protection'   => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quote';
    }
}