<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * DictionaryEntry
 *
 * @ORM\Table(name="dictionary_entry")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DictionaryEntryRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class DictionaryEntry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="integer")
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     */
    private $position = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="supplier_name", type="string", length=255, nullable=true)
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     */
    private $supplier_name;

    /**
     * @var string
     *
     * @ORM\Column(name="data", type="text", length=8192, nullable=true)
     * @Serializer\Groups({"dictionary-entry-list"})
     * @Serializer\Expose
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="Dictionary", inversedBy="entries")
     * @ORM\JoinColumn(name="dictionary_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $dictionary;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DictionaryEntryProfile", mappedBy="entry")
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    private $dictionaryEntryProfiles;


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
     * Set name
     *
     * @param string $name
     *
     * @return DictionaryEntry
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
     * Set supplier name
     *
     * @param string $name
     *
     * @return DictionaryEntry
     */
    public function setSupplierName($supplier_name)
    {
        $this->supplier_name = $supplier_name;

        return $this;
    }

    /**
     * Get supplier name
     *
     * @return string
     */
    public function getSupplierName()
    {
        return $this->supplier_name;
    }

    /**
     * Set data
     *
     * @param string $data
     *
     * @return DictionaryEntry
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set dictionary
     *
     * @param Dictionary $dictionary
     *
     * @return DictionaryEntry
     */
    public function setDictionary(Dictionary $dictionary = null)
    {
        $this->dictionary = $dictionary;

        return $this;
    }

    /**
     * Get dictionary
     *
     * @return \AppBundle\Entity\Dictionary
     */
    public function getDictionary()
    {
        return $this->dictionary;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return DictionaryEntry
     */
    public function setPosition($position)
    {
        $this->position = $position;

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

    /**
     * @return mixed
     */
    public function getDictionaryEntryProfiles()
    {
        return $this->dictionaryEntryProfiles;
    }
}
