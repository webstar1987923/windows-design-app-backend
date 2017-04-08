<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DictionaryEntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('supplier_name')
            ->add('data')
            ->add('position')
            ->add('dictionary_entry_profiles', 'collection', [
                'type'      => new DictionaryEntryProfileType(),
                'mapped'    => false,
                'allow_add' => true,
            ]);
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $e){
            $form = $e->getForm();

            $profileIds = array_map(function($form){
                return $form->getData()->getProfileId();
            }, $form['dictionary_entry_profiles']->all());

            if (!empty($profileIds)) {
                if (max(array_count_values($profileIds)) !== 1) {
                    $form->addError(new FormError('Duplicate profiles'));
                }
            }
        });
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DictionaryEntry',
            'csrf_protection'   => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'entry';
    }
}
