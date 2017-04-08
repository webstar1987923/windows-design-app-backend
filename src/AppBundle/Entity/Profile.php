<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name="profiles")
 * @ExclusionPolicy("all")
 */
class Profile
{
    const PRICING_SCHEME_NONE = 'NONE';
    const PRICING_SCHEME_PRICING_GRIDS = 'PRICING_GRIDS';
    const PRICING_SCHEME_LINEAR_EQUATION = 'LINEAR_EQUATION';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->units = new ArrayCollection();
        $this->dictionary_entries = new ArrayCollection();
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
     * @Groups({"profile-list", "profile-details", "project-details"})
     * @Expose
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $position;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details", "project-details"})
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $unit_type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $system;

    /**
     * @var float
     *
     * @ORM\Column(name="frame_width", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $frame_width;

    /**
     * @var float
     *
     * @ORM\Column(name="mullion_width", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $mullion_width;

    /**
     * @var float
     *
     * @ORM\Column(name="sash_frame_width", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $sash_frame_width;

    /**
     * @var float
     *
     * @ORM\Column(name="sash_frame_overlap", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $sash_frame_overlap;

    /**
     * @var float
     *
     * @ORM\Column(name="sash_mullion_overlap", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $sash_mullion_overlap;

    /**
     * @var string
     *
     * @ORM\Column(name="frame_corners", type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $frame_corners;

    /**
     * @var string
     *
     * @ORM\Column(name="sash_corners", type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $sash_corners;

    /**
     * @var float
     *
     * @ORM\Column(name="threshold_width", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $threshold_width;

    /**
     * @var boolean
     *
     * @ORM\Column(name="low_threshold", type="boolean", nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $low_threshold;

    /**
     * @var float
     *
     * @ORM\Column(name="frame_u_value", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $frame_u_value;

    /**
     * @var float
     *
     * @ORM\Column(name="spacer_thermal_bridge_value", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */    
    protected $spacer_thermal_bridge_value;

    /**
     * @var float
     *
     * @ORM\Column(name="fixed_uf", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $fixed_uf;

    /**
     * @var float
     *
     * @ORM\Column(name="operable_uf", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $operable_uf;

    /**
     * @var float
     *
     * @ORM\Column(name="mullion_uf", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $mullion_uf;

    /**
     * @var float
     *
     * @ORM\Column(name="edge_of_glazing_u_value", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $edge_of_glazing_u_value;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_scheme", type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $pricing_scheme;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_grids", type="text", length=8192, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $pricing_grids;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_equation_params", type="text", length=8192, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $pricing_equation_params;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Unit", mappedBy="profile", cascade={"persist"})
     * @Groups({"profile-details"})
     * @Expose
     **/
    protected $units;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $supplier_system;

    /**
     * @ORM\OneToMany(targetEntity="DictionaryEntryProfile", mappedBy="entry")
     **/
    protected $dictionary_entries;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FillingTypeProfile", mappedBy="profile")
     */
    protected $fillingTypeProfiles;

    /**
     * @var float
     *
     * @ORM\Column(name="weight_per_length", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $weight_per_length;

    /**
     * @ORM\Column(name="clear_width_deduction", type="decimal", precision=19, scale=4, nullable=true)
     * @Groups({"profile-list", "profile-details"})
     * @Expose
     */
    protected $clear_width_deduction;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $value
     * @return Profile
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
     * @return Profile
     */
    public function setName($value)
    {
        $this->name = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitType()
    {
        return $this->unit_type;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setUnitType($value)
    {
        $this->unit_type = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSystem()
    {
        return $this->system;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setSystem($value)
    {
        $this->system = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getFrameWidth()
    {
        return $this->frame_width;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setFrameWidth($value)
    {
        $this->frame_width = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getMullionWidth()
    {
        return $this->mullion_width;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setMullionWidth($value)
    {
        $this->mullion_width = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getSashFrameWidth()
    {
        return $this->sash_frame_width;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setSashFrameWidth($value)
    {
        $this->sash_frame_width = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getSashFrameOverlap()
    {
        return $this->sash_frame_overlap;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setSashFrameOverlap($value)
    {
        $this->sash_frame_overlap = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getSashMullionOverlap()
    {
        return $this->sash_mullion_overlap;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setSashMullionOverlap($value)
    {
        $this->sash_mullion_overlap = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrameCorners()
    {
        return $this->frame_corners;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setFrameCorners($value)
    {
        $this->frame_corners = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getSashCorners()
    {
        return $this->sash_corners;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setSashCorners($value)
    {
        $this->sash_corners = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getThresholdWidth()
    {
        return $this->threshold_width;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setThresholdWidth($value)
    {
        $this->threshold_width = $value;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getLowThreshold()
    {
        return $this->low_threshold;
    }

    /**
     * @param boolean $value
     * @return Profile
     */
    public function setLowThreshold($value)
    {
        $this->low_threshold = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getFrameUValue()
    {
        return $this->frame_u_value;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setFrameUValue($value)
    {
        $this->frame_u_value = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getSpacerThermalBridgeValue()
    {
        return $this->spacer_thermal_bridge_value;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setSpacerThermalBridgeValue($value)
    {
        $this->spacer_thermal_bridge_value = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getFixedUf()
    {
        return $this->fixed_uf;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setFixedUf($value)
    {
        $this->fixed_uf = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getOperableUf()
    {
        return $this->operable_uf;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setOperableUf($value)
    {
        $this->operable_uf = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getMullionUf()
    {
        return $this->mullion_uf;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setMullionUf($value)
    {
        $this->mullion_uf = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getEdgeOfGlazingUValue()
    {
        return $this->edge_of_glazing_u_value;
    }

    /**
     * @param float $value
     * @return Profile
     */
    public function setEdgeOfGlazingUValue($value)
    {
        $this->edge_of_glazing_u_value = $value;
        return $this;
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
     * @return Profile
     */
    public function setPricingScheme($value)
    {
        $this->pricing_scheme = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPricingGrids()
    {
        return $this->pricing_grids;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setPricingGrids($value)
    {
        $this->pricing_grids = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getPricingEquationParams()
    {
        return $this->pricing_equation_params;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setPricingEquationParams($value)
    {
        $this->pricing_equation_params = $value;
        return $this;
    }


    /**
     * Add unit
     *
     * @param Unit $value
     * @return Profile
     */
    public function addWindow(Unit $value)
    {
        $value->setProfile($this);
        $this->units[] = $value;
        return $this;
    }

    /**
     * Remove unit
     *
     * @param Unit $value
     */
    public function removeWindow(Unit $value)
    {
        $value->setProfile(null);
        $this->units->removeElement($value);
    }

    /**
     * Set units
     *
     * @param ArrayCollection $value
     * @return array Unit
     */
    public function setWindows(ArrayCollection $value)  {
        foreach($value as $item) {
            $item->setProfile($this);
        }
        $this->units = $value;
        return $this;
    }

    /**
     * Returns units
     *
     * @return array Unit
     */
    public function getWindows() {
        return $this->units;
    }

    /**
     * @return string
     */
    public function getSupplierSystem()
    {
        return $this->supplier_system;
    }

    /**
     * @param string $value
     * @return Profile
     */
    public function setSupplierSystem($value)
    {
        $this->supplier_system = $value;
        return $this;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Profile
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
    public function setWeightPerLength($value)
    {
        $this->weight_per_length = $value;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeightPerLength()
    {
        return $this->weight_per_length;
    }

    /**
     * Add unit
     *
     * @param \AppBundle\Entity\Unit $unit
     *
     * @return Profile
     */
    public function addUnit(\AppBundle\Entity\Unit $unit)
    {
        $unit->setProfile($this);
        $unit->setProfileName($this->getName());
        $this->units[] = $unit;
        return $this;
    }

    /**
     * Remove unit
     *
     * @param \AppBundle\Entity\Unit $unit
     */
    public function removeUnit(\AppBundle\Entity\Unit $unit)
    {
        $this->units->removeElement($unit);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Add dictionaryEntry
     *
     * @param \AppBundle\Entity\DictionaryEntry $dictionaryEntry
     *
     * @return Profile
     */
    public function addDictionaryEntry(\AppBundle\Entity\DictionaryEntry $dictionaryEntry)
    {
        $this->dictionary_entries[] = $dictionaryEntry;

        return $this;
    }

    /**
     * Remove dictionaryEntry
     *
     * @param \AppBundle\Entity\DictionaryEntry $dictionaryEntry
     */
    public function removeDictionaryEntry(\AppBundle\Entity\DictionaryEntry $dictionaryEntry)
    {
        $this->dictionary_entries->removeElement($dictionaryEntry);
    }

    /**
     * Get dictionaryEntries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDictionaryEntries()
    {
        return $this->dictionary_entries;
    }

    /**
     * @return mixed
     */
    public function getClearWidthDeduction()
    {
        return $this->clear_width_deduction;
    }

    /**
     * @param mixed $clear_width_deduction
     * @return self
     */
    public function setClearWidthDeduction($clear_width_deduction)
    {
        $this->clear_width_deduction = $clear_width_deduction;
        return $this;
    }
}
