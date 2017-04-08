<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * Dictionary
 *
 * @ORM\Table(name="dictionary")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class Dictionary
{
    const PRICING_SCHEME_NONE = 'NONE';
    const PRICING_SCHEME_PER_ITEM = 'PER_ITEM';
    const PRICING_SCHEME_PRICING_GRIDS = 'PRICING_GRIDS';
    const PRICING_SCHEME_LINEAR_EQUATION = 'LINEAR_EQUATION';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"dictionary-list"})
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"dictionary-list"})
     * @Serializer\Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="rules_and_restrictions", type="string", length=8192, nullable=true)
     * @Serializer\Groups({"dictionary-list"})
     * @Serializer\Expose
     */
    private $rules_and_restrictions;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_scheme", type="string", length=255, nullable=true)
     * @Serializer\Groups({"dictionary-list"})
     * @Serializer\Expose
     */
    private $pricing_scheme;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     * @Serializer\Groups({"dictionary-list"})
     * @Serializer\Expose
     */
    private $position = 0;

    /**
     * @ORM\OneToMany(targetEntity="DictionaryEntry", mappedBy="dictionary", cascade={"persist", "remove"})
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     **/
    private $entries;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function setId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Dictionary
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set rules and restrictions
     *
     * @param string $rules_and_restrictions
     *
     * @return Dictionary
     */
    public function setRulesAndRestrictions($rules_and_restrictions)
    {
        $this->rules_and_restrictions = $rules_and_restrictions;

        return $this;
    }

    /**
     * Get rules and restrictions
     *
     * @return string
     */
    public function getRulesAndRestrictions()
    {
        return $this->rules_and_restrictions;
    }

    /**
     * Set pricing_scheme
     *
     * @param string $pricing_scheme
     *
     * @return Dictionary
     */
    public function setPricingScheme($pricing_scheme)
    {
        $this->pricing_scheme = $pricing_scheme;

        return $this;
    }

    /**
     * Get pricing_scheme
     *
     * @return string
     */
    public function getPricingScheme()
    {
        return $this->pricing_scheme;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add entry
     *
     * @param \AppBundle\Entity\DictionaryEntry $entry
     *
     * @return Dictionary
     */
    public function addEntry(\AppBundle\Entity\DictionaryEntry $entry)
    {
        $entry->setDictionary($this);
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Remove entry
     *
     * @param \AppBundle\Entity\DictionaryEntry $entry
     */
    public function removeEntry(\AppBundle\Entity\DictionaryEntry $entry)
    {
        $this->entries->removeElement($entry);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Dictionary
     */
    public function setPosition($position)
    {
        $this->position = $position ?: 0;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
