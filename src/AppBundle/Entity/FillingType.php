<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FillingTypeRepository")
 * @ORM\Table(name="filling_types")
 * @Serializer\ExclusionPolicy("all")
 */
class FillingType
{
    const PRICING_SCHEME_NONE = 'NONE';
    const PRICING_SCHEME_PRICING_GRIDS = 'PRICING_GRIDS';
    const PRICING_SCHEME_LINEAR_EQUATION = 'LINEAR_EQUATION';

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * String representation of object
     * @return string
     */
    public function __toString()
    {
        return $this->getId();
    }

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Expose
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $supplier_name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $type;

    /**
     * @var float
     *
     * @ORM\Column(name="weight_per_area", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Expose
     */
    protected $weight_per_area;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_scheme", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $pricing_scheme;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FillingTypeProfile", mappedBy="fillingType")
     * @Serializer\Expose
     * @Serializer\SerializedName("filling_type_profiles")
     */
    protected $fillingTypeProfiles;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return FillingType
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
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
     * @return FillingType
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSupplierName()
    {
        return $this->supplier_name;
    }

    /**
     * @param string $value
     * @return FillingType
     */
    public function setSupplierName($value)
    {
        $this->supplier_name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $value
     * @return FillingType
     */
    public function setType($value)
    {
        $this->type = $value;
        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return FillingType
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
     *
     * @param float $value
     */
    public function setWeightPerArea($value)
    {
        $this->weight_per_area = $value;
    }

    /**
     *
     * @return float
     */
    public function getWeightPerArea()
    {
        return $this->weight_per_area;
    }

    /**
     * @return string
     */
    public function getPricingScheme()
    {
        return $this->pricing_scheme;
    }

    /**
     * @param string $value
     * @return FillingType
     */
    public function setPricingScheme($value)
    {
        $this->pricing_scheme = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFillingTypeProfiles()
    {
        return $this->fillingTypeProfiles;
    }
}
