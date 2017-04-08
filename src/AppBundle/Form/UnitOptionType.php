<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\EntityManager;

use AppBundle\Entity\Unit;

/**
 * Class UnitOptionType
 */
class UnitOptionType extends AbstractType
{
    /**
     * @var Unit
     */
    private $unit;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UnitOptionType constructor.
     * @param Unit $unit
     * @param EntityManager $em
     */
    public function __construct(Unit $unit, EntityManager $em)
    {
        $this->unit = $unit;
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dictionary_entry_id')
            ->add('dictionary_id')
            ->add('quantity')
        ;

        $builder->addEventListener(FormEvents::SUBMIT, function(FormEvent $e){
            $unitOption = $e->getData();
            $entryId = $unitOption->getDictionaryEntryId();

            /* @var $entry \AppBundle\Entity\DictionaryEntry */
            $entry = $this->em->find("AppBundle:DictionaryEntry", $entryId);

            $unitOption->setUnit($this->unit);
            $unitOption->setDictionaryEntry($entry);
            $unitOption->setDictionary($entry->getDictionary());

            $e->setData($unitOption);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'data_class'      => 'AppBundle\Entity\UnitOption',
            'csrf_protection' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
}
