<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

use JMS\Serializer\Annotation as Serializer;

/**
 * DictionaryEntryProfile
 *
 * @ORM\Table(
 *     name="dictionary_entry_profile",
 *     uniqueConstraints={@UniqueConstraint(name="idx_dictentry_profile", columns={"dictionary_entry_id", "profile_id"})}
 * )
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 */
class DictionaryEntryProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="DictionaryEntry", inversedBy="dictionaryEntryProfiles")
     * @ORM\JoinColumn(name="dictionary_entry_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $entry;

    /**
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="dictionary_entries")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;

    /**
     * @var integer
     */
    private $profile_id;

    /**
     * @ORM\Column(name="is_default", type="boolean", nullable=false)
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    private $isDefault = false;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_grids", type="text", length=8192, nullable=true)
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    protected $pricing_grids;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_equation_params", type="text", length=8192, nullable=true)
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    protected $pricing_equation_params;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_per_item", type="decimal", precision=19, scale=4, nullable=true)
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     * @Serializer\Expose
     */
    protected $cost_per_item;

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
     * Set profile
     *
     * @param \stdClass $profile
     *
     * @return DictionaryEntryProfile
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \stdClass
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param mixed $profile_id
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("profile_id")
     * @Serializer\Groups({"dictionary-entry-list", "dictionary-list"})
     *
     * @return integer
     */
    public function getProfileId()
    {
        if (!empty($this->profile_id)) {
            return $this->profile_id;
        } else {
            if ($this->profile instanceof Profile) {
                return $this->profile->getId();
            }
        }

        return null;
    }

    /**
     * Set entry
     *
     * @param \AppBundle\Entity\DictionaryEntry $entry
     *
     * @return DictionaryEntryProfile
     */
    public function setEntry(\AppBundle\Entity\DictionaryEntry $entry = null)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return \AppBundle\Entity\DictionaryEntry
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param boolean $isDefault
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = ($isDefault === true);
    }

    /**
     * @return string
     */
    public function getPricingGrids()
    {
        return $this->pricing_grids;
    }

    /**
     * @param string $grids
     * @return self
     */
    public function setPricingGrids($grids)
    {
        $this->pricing_grids = $grids;
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
     * @return self
     */
    public function setPricingEquationParams($value)
    {
        $this->pricing_equation_params = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getCostPerItem()
    {
        return $this->cost_per_item;
    }

    /**
     * @param float $cost_per_item
     * @return self
     */
    public function setCostPerItem($cost_per_item)
    {
        $this->cost_per_item = $cost_per_item;
        return $this;
    }
}
