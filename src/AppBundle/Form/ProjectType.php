<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("client_name");
        $builder->add("client_company_name");
        $builder->add("client_phone");
        $builder->add("client_email", "email");
        $builder->add("client_address");
        $builder->add("project_name");
        $builder->add("project_address");
        $builder->add("quote_date");
        $builder->add("quote_revision");
        $builder->add("project_notes", 'textarea', array('required' => false));
        $builder->add("shipping_notes", 'textarea', array('required' => false));
        $builder->add("settings");
        $builder->add("lead_time");
        $builder->add("frontapp_thread_id");
        $builder->add("frontapp_gdrive_folder_id");
        $builder->add("dapulse_pulse_id");
        $builder->add("extra_id_data");
        $builder->add('files', 'collection', [
            'type'      => 'text',
            'mapped'    => false,
            'allow_add' => true,
        ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event){
            // remove the files field if the request doesn't contain it
            // we don't want to implicitly delete Project Files
            if (!array_key_exists('files', $event->getData())) {
                $event->getForm()->remove('files');
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Project',
            'csrf_protection' => false,
        ]);
    }

    public function getName()
    {
        return 'project';
    }
}
