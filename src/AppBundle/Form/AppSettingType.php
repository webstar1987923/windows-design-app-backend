<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class AppSettingType extends AbstractType
{
    CONST SAVE_RATIO = 'thumbnails_save_ratio';
    CONST WIDTH = 'thumbnails_width';
    CONST HEIGHT = 'thumbnails_height';
    CONST QUALITY = 'thumbnails_quality';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //dump($builder);
        //$label = $options['data']->getDisplayName();
        $builder->add("system_name", 'hidden');
        $builder->add("display_name", 'hidden');
        //$builder->add("value", 'text', array('auto_initialize' => false,));

        $formFactory = $builder->getFormFactory();
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formFactory) {
            $form = $event->getForm();
            $data = $event->getData();
            switch ($data->getSystemName()) {
                case self::WIDTH:
                    $form->add('value', 'integer', array(
                        'label' => $data->getDisplayName(),
                        'attr' => array(
                            'class' => 'thumbnail-width',
                            'min'   => 0,
                        ),
                        'constraints' => array(
                            new GreaterThanOrEqual(array(
                                'value' => 0,
                            ))
                        ),
                    ));
                    break;
                case self::HEIGHT:
                    $form->add('value', 'integer', array(
                        'label' => $data->getDisplayName(),
                        'attr' => array(
                            'class' => 'thumbnail-height',
                            'min'   => 0,
                        ),
                        'constraints' => array(
                            new GreaterThanOrEqual(array(
                                'value' => 0,
                            ))
                        ),
                    ));
                    break;
                case self::QUALITY:
                    $form->add('value', 'integer', array(
                        'label' => $data->getDisplayName(),
                        'attr' => array(
                            'min' => 0,
                        ),
                        'constraints' => array(
                            new GreaterThanOrEqual(array(
                                'value' => 0,
                            ))
                        ),
                    ));
                    break;
                case self::SAVE_RATIO:
                    $form->add('value', 'choice',
                        array('label' => $data->getDisplayName(),
                            'choices' => array(
                                '1' => 'Enabled',
                                '0' => 'Disabled'
                            ),
                            'attr' => array('class' => 'save-ratio-select')
                        ));
                    break;
                default:
                    break;
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\AppSetting',
            'csrf_protection' => true,
        ));
    }

    public function getName()
    {
        return 'app_setting';
    }
}
