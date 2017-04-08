<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Quote
 *
 * @ORM\Entity
 * @ORM\Table(name="quotes")
 * @ExclusionPolicy("all")
 */
class Quote
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $revision;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $date;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     * @Groups({"project-details", "list", "details"})
     * @Expose
     */
    protected $is_default = false;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Accessory", mappedBy="quote", cascade={"persist", "remove"})
     * @Groups({"project-details", "list", "details"})
     * @Expose
     **/
    protected $accessories;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Unit", mappedBy="quote", cascade={"persist", "remove"})
     * @Groups({"project-details", "list", "details"})
     * @Expose
     **/
    protected $units;


    /**
     * Quote constructor.
     */
    public function __construct()
    {
        $this->accessories = new ArrayCollection();
        $this->units = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     * @return Quote
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * @param int $value
     * @return Quote
     */
    public function setRevision($value)
    {
        $this->revision = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $value
     * @return Quote
     */
    public function setDate($value)
    {
        $this->date = $value;
        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Quote
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
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     * @return Quote
     */
    public function setProject(Project $project)
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsDefault()
    {
        return $this->is_default;
    }

    /**
     * @param boolean $is_default
     * @return Quote
     */
    public function setIsDefault($is_default)
    {
        $this->is_default = $is_default;
        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    /**
     * Add Accessory
     *
     * @param Accessory $value
     * @return Quote
     */
    public function addAccessory(Accessory $value)
    {
        // TODO: Check file already exists in collection
        $this->accessories[] = $value;
        return $this;
    }

    /**
     * Remove Accessory
     *
     * @param Accessory $value
     */
    public function removeAccessory(Accessory $value)
    {
        // TODO: Check if exists
        $this->accessories->removeElement($value);
    }

    /**
     * Set Accessories
     *
     * @param ArrayCollection $value
     * @return Quote
     */
    public function setAccessories(ArrayCollection $value)
    {
        $this->accessories = $value;
        return $this;
    }

    /**
     * Returns Accessories
     *
     * @return ArrayCollection
     */
    public function getAccessories()
    {
        return $this->accessories;
    }

    /**
     * Add Unit
     *
     * @param Unit $value
     * @return Quote
     */
    public function addUnit(Unit $value)
    {
        // TODO: Check file already exists in collection
        $this->units[] = $value;
        return $this;
    }

    /**
     * Remove Unit
     *
     * @param Unit $value
     */
    public function removeUnit(Unit $value)
    {
        // TODO: Check if exists
        $this->units->removeElement($value);
    }

    /**
     * Set Units
     *
     * @param ArrayCollection $value
     * @return Quote
     */
    public function setUnits(ArrayCollection $value)
    {
        $this->units = $value;
        return $this;
    }

    /**
     * Returns Units
     *
     * @return ArrayCollection
     */
    public function getUnits()
    {
        return $this->units;
    }
}
