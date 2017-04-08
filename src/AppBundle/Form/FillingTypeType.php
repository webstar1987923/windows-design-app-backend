<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FillingTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('supplier_name')
            ->add('type')
            ->add('position')
            ->add('weight_per_area')
            ->add("pricing_scheme")
            ->add('filling_type_profiles', 'collection', array(
                'type'      => new FillingTypeProfileType(),
                'mapped'    => false,
                'allow_add' => true,
            ))
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $e){
            $form = $e->getForm();

            $profileIds = array_map(function($form){
                return $form->getData()->getProfileId();
            }, $form['filling_type_profiles']->all());

            if (!empty($profileIds)) {
                if (max(array_count_values($profileIds)) !== 1) {
                    $form->addError(new FormError('Duplicate profiles'));
                }
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\FillingType',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'filling_type';
    }
}
