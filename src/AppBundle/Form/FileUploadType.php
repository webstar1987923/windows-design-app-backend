<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Class FileUploadType
 */
class FileUploadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', 'text', [
                'required'    => true,
                'constraints' => [
                    new NotBlank(),
                    new Url(),
                ],
            ])
            ->add('headers', 'collection', [
                'type'               => 'text',
                'allow_add'          => true,
                'allow_extra_fields' => true,
            ])
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
            $data = $event->getData();

            if (!empty($data['headers'])) {
                foreach ($data['headers'] as $header => $value) {
                    if (!is_string($value)) {
                        $event->getForm()->get('headers')->get($header)->addError(new FormError('Value must be a string'));
                    }
                }
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'file';
    }
}
