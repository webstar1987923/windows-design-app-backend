<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * UnitOption
 *
 * @ORM\Table(name="unit_option")
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class UnitOption
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Unit
     *
     * @ORM\ManyToOne(targetEntity="Unit", inversedBy="options")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id")
     */
    private $unit;

    /**
     * @var Dictionary
     *
     * @ORM\ManyToOne(targetEntity="Dictionary")
     * @ORM\JoinColumn(name="dictionary_id", referencedColumnName="id")
     */
    private $dictionary;

    /**
     * @var DictionaryEntry
     *
     * @ORM\ManyToOne(targetEntity="DictionaryEntry")
     * @ORM\JoinColumn(name="dictionary_entry_id", referencedColumnName="id")
     */
    private $dictionaryEntry;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Expose
     */
    protected $quantity;


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
     * Set unit
     *
     * @param string $unit
     *
     * @return UnitOption
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set dictionary
     *
     * @param Dictionary $dictionary
     *
     * @return UnitOption
     */
    public function setDictionary(Dictionary $dictionary)
    {
        $this->dictionary = $dictionary;

        return $this;
    }

    /**
     * Get dictionary
     *
     * @return Dictionary
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * Set dictionaryEntry
     *
     * @param DictionaryEntry $dictionaryEntry
     *
     * @return UnitOption
     */
    public function setDictionaryEntry(DictionaryEntry $dictionaryEntry)
    {
        $this->dictionaryEntry = $dictionaryEntry;

        return $this;
    }

    /**
     * Get dictionaryEntry
     *
     * @return DictionaryEntry
     */
    public function getDictionaryEntry()
    {
        return $this->dictionaryEntry;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("dictionary_id")
     *
     * @return int
     */
    public function getDictionaryId()
    {
        if (!empty($this->dictionary_id)) {
            return $this->dictionary_id;
        } else {
            if ($this->dictionary instanceof Dictionary) {
                return $this->dictionary->getId();
            }
        }

        return null;
    }

    /**
     * @param mixed $dictionary_id
     */
    public function setDictionaryId($dictionary_id)
    {
        $this->dictionary_id = $dictionary_id;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("dictionary_entry_id")
     *
     * @return int
     */
    public function getDictionaryEntryId()
    {
        if (!empty($this->dictionary_entry_id)) {
            return $this->dictionary_entry_id;
        } else {
            if ($this->dictionaryEntry instanceof DictionaryEntry) {
                return $this->dictionaryEntry->getId();
            }
        }

        return null;
    }

    /**
     * @param mixed $dictionary_entry_id
     */
    public function setDictionaryEntryId($dictionary_entry_id)
    {
        $this->dictionary_entry_id = $dictionary_entry_id;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $value
     * @return UnitOption
     */
    public function setQuantity($value)
    {
        $this->quantity = $value;
        return $this;
    }
}
