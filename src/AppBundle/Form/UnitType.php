<?php

namespace AppBundle\Form;

use AppBundle\Entity\Unit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityManager;

class UnitType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UnitType constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!empty($options['data'])) {
            $data = $options['data'];
        } else {
            $data = new Unit();
        }

        $builder->add("mark");
        $builder->add("width");
        $builder->add("height");
        $builder->add("quantity");
        $builder->add("description");
        $builder->add("notes");
        $builder->add("exceptions");
        $builder->add("profile_id");
        $builder->add("profile_name");
        $builder->add("customer_image");
        $builder->add("internal_color");
        $builder->add("external_color");
        $builder->add("interior_handle");
        $builder->add("exterior_handle");
        $builder->add("hardware_type");
        $builder->add("lock_mechanism");
        $builder->add("glazing_bead");
        $builder->add("gasket_color");
        $builder->add("hinge_style");
        $builder->add("opening_direction");
        $builder->add("internal_sill");
        $builder->add("external_sill");
        $builder->add("glazing");
        $builder->add("uw");
        $builder->add("original_cost");
        $builder->add("original_currency");
        $builder->add("conversion_rate");
        $builder->add("supplier_discount");
        $builder->add("price_markup");
        $builder->add("discount");
        $builder->add("root_section");
        $builder->add("glazing_bar_width");
        $builder->add("glazing_bar_type");
        $builder->add("position");
        $builder->add('unit_options', 'collection', [
            'type'      => new UnitOptionType($data, $this->em),
            'allow_add' => true,
            'mapped'    => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'AppBundle\Entity\Unit',
            'csrf_protection'   => false,
        ));
    }

    public function getName()
    {
        return 'unit';
    }
}
