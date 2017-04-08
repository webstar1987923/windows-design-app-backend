<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Table(name="units")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Unit
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->options = new ArrayCollection();
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
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $mark;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $width;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $height;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $quantity;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $notes;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $exceptions;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_name", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $profile_name;

    /**
     * @var int
     *
     * @ORM\Column(name="profile_id", type="integer", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $profile_id;

    /**
     * @var string
     *
     * @ORM\Column(name="customer_image", type="text", nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $customer_image;

    /**
     * @var string
     *
     * @ORM\Column(name="internal_color", type="string", length=50, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $internal_color;

    /**
     * @var string
     *
     * @ORM\Column(name="external_color", type="string", length=50, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $external_color;

    /**
     * @var string
     *
     * @ORM\Column(name="interior_handle", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $interior_handle;

    /**
     * @var string
     *
     * @ORM\Column(name="exterior_handle", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $exterior_handle;

    /**
     * @var string
     *
     * @ORM\Column(name="hardware_type", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $hardware_type;

    /**
     * @var string
     *
     * @ORM\Column(name="lock_mechanism", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $lock_mechanism;

    /**
     * @var string
     *
     * @ORM\Column(name="glazing_bead", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $glazing_bead;

    /**
     * @var string
     *
     * @ORM\Column(name="gasket_color", type="string", length=50, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $gasket_color;

    /**
     * @var string
     *
     * @ORM\Column(name="hinge_style", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $hinge_style;

    /**
     * @var string
     *
     * @ORM\Column(name="opening_direction", type="string", length=50, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $opening_direction;

    /**
     * @var string
     *
     * @ORM\Column(name="internal_sill", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $internal_sill;

    /**
     * @var string
     *
     * @ORM\Column(name="external_sill", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $external_sill;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $glazing;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $uw;

    /**
     * @var float
     *
     * @ORM\Column(name="original_cost", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $original_cost;

    /**
     * @var string
     *
     * @ORM\Column(name="original_currency", type="string", length=100, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $original_currency;

    /**
     * @var float
     *
     * @ORM\Column(name="conversion_rate", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $conversion_rate;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $supplier_discount;

    /**
     * @var float
     *
     * @ORM\Column(name="price_markup", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $price_markup;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=7, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="root_section", type="text", length=8192, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $root_section;

    /**
     * @var float
     *
     * @ORM\Column(name="glazing_bar_width", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $glazing_bar_width;

    /**
     * @var string
     *
     * @ORM\Column(name="glazing_bar_type", type="string", length=255, nullable=true)
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $glazing_bar_type;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Quote")
     * @ORM\JoinColumn(name="quote_id", referencedColumnName="id")
     */
    protected $quote;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Profile", inversedBy="units")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id", onDelete="CASCADE")
     * @Serializer\Groups({"list", "details", "project-details"})
     * @Serializer\Expose
     */
    protected $profile;

    /**
     * @ORM\OneToMany(targetEntity="UnitOption", mappedBy="unit", cascade={"persist", "remove"})
     * @Serializer\Expose
     * @Serializer\SerializedName("unit_options")
     **/
    protected $options;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return Unit
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setMark($value)
    {
        $this->mark = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setWidth($value)
    {
        $this->width = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setHeight($value)
    {
        $this->height = $value;
        return $this;
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
     * @return Unit
     */
    public function setQuantity($value)
    {
        $this->quantity = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setDescription($value)
    {
        $this->description = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setNotes($value)
    {
        $this->notes = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setExceptions($value)
    {
        $this->exceptions = $value;
        return $this;
    }

    /**
     * @return int
     */
    public function getProfileId()
    {
        return $this->profile_id;
    }

    /**
     * @param int $value
     * @return Unit
     */
    public function setProfileId($value)
    {
        $this->profile_id = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfileName()
    {
        return $this->profile_name;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setProfileName($value)
    {
        $this->profile_name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerImage()
    {
        return $this->customer_image;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setCustomerImage($value)
    {
        $this->customer_image = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getInternalColor()
    {
        return $this->internal_color;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setInternalColor($value)
    {
        $this->internal_color = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalColor()
    {
        return $this->external_color;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setExternalColor($value)
    {
        $this->external_color = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getInteriorHandle()
    {
        return $this->interior_handle;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setInteriorHandle($value)
    {
        $this->interior_handle = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExteriorHandle()
    {
        return $this->exterior_handle;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setExteriorHandle($value)
    {
        $this->exterior_handle = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHardwareType()
    {
        return $this->hardware_type;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setHardwareType($value)
    {
        $this->hardware_type = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getLockMechanism()
    {
        return $this->lock_mechanism;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setLockMechanism($value)
    {
        $this->lock_mechanism = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGlazingBead()
    {
        return $this->glazing_bead;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setGlazingBead($value)
    {
        $this->glazing_bead = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGasketColor()
    {
        return $this->gasket_color;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setGasketColor($value)
    {
        $this->gasket_color = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getHingeStyle()
    {
        return $this->hinge_style;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setHingeStyle($value)
    {
        $this->hinge_style = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOpeningDirection()
    {
        return $this->opening_direction;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setOpeningDirection($value)
    {
        $this->opening_direction = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getInternalSill()
    {
        return $this->internal_sill;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setInternalSill($value)
    {
        $this->internal_sill = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getExternalSill()
    {
        return $this->external_sill;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setExternalSill($value)
    {
        $this->external_sill = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGlazing()
    {
        return $this->glazing;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setGlazing($value)
    {
        $this->glazing = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getUw()
    {
        return $this->uw;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setUw($value)
    {
        $this->uw = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getOriginalCost()
    {
        return $this->original_cost;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setOriginalCost($value)
    {
        $this->original_cost = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalCurrency()
    {
        return $this->original_currency;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setOriginalCurrency($value)
    {
        $this->original_currency = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getConversionRate()
    {
        return $this->conversion_rate;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setConversionRate($value)
    {
        $this->conversion_rate = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getSupplierDiscount()
    {
        return $this->supplier_discount;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setSupplierDiscount($value)
    {
        $this->supplier_discount = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMarkup()
    {
        return $this->price_markup;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setPriceMarkup($value)
    {
        $this->price_markup = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setDiscount($value)
    {
        $this->discount = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getRootSection()
    {
        return $this->root_section;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setRootSection($value)
    {
        $this->root_section = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getGlazingBarWidth()
    {
        return $this->glazing_bar_width;
    }

    /**
     * @param float $value
     * @return Unit
     */
    public function setGlazingBarWidth($value)
    {
        $this->glazing_bar_width = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getGlazingBarType()
    {
        return $this->glazing_bar_type;
    }

    /**
     * @param string $value
     * @return Unit
     */
    public function setGlazingBarType($value)
    {
        $this->glazing_bar_type = $value;
        return $this;
    }

    /**
     * @return Quote
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param Quote $quote
     * @return Unit
     */
    public function setQuote(Quote $quote)
    {
        $this->quote = $quote;
        return $this;
    }

    /**
     * Set profile
     *
     * @param Profile $value
     * @return Unit
     */
    public function setProfile(Profile $value = null)
    {
        $this->profile = $value;
        return $this;
    }

    /**
     * Get profile
     *
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set number
     *
     * @param integer $position
     *
     * @return Unit
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add option
     *
     * @param \AppBundle\Entity\UnitOption $option
     *
     * @return Unit
     */
    public function addOption(\AppBundle\Entity\UnitOption $option)
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * Remove option
     *
     * @param \AppBundle\Entity\UnitOption $option
     */
    public function removeOption(\AppBundle\Entity\UnitOption $option)
    {
        $this->options->removeElement($option);
    }

    /**
     * Get options
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptions()
    {
        return $this->options;
    }
}
