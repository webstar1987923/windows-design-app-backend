<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("name");
        $builder->add("unit_type");
        $builder->add("system");
        $builder->add("supplier_system");
        $builder->add("frame_width");
        $builder->add("mullion_width");
        $builder->add("sash_frame_width");
        $builder->add("sash_frame_overlap");
        $builder->add("sash_mullion_overlap");
        $builder->add("frame_corners");
        $builder->add("sash_corners");
        $builder->add("threshold_width");
        $builder->add("low_threshold");
        $builder->add("frame_u_value");
        $builder->add("spacer_thermal_bridge_value");
        $builder->add("fixed_uf");
        $builder->add("operable_uf");
        $builder->add("mullion_uf");
        $builder->add("edge_of_glazing_u_value");
        $builder->add("pricing_scheme");
        $builder->add("pricing_grids");
        $builder->add("pricing_equation_params");
        $builder->add("position");
        $builder->add("weight_per_length");
        $builder->add("clear_width_deduction");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\Profile',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'profile';
    }
}
