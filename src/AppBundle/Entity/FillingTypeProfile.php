<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class FillingTypeProfile
 *
 * @ORM\Table(
 *     name="filling_type_profile",
 *     uniqueConstraints={@UniqueConstraint(name="idx_fillingtype_profile", columns={"filling_type_id", "profile_id"})}
 * )
 * @ORM\Entity
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\XmlRoot("filling_type_profiles")
 */
class FillingTypeProfile
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    private $id;

    /**
     * @var Profile
     *
     * @ORM\ManyToOne(targetEntity="Profile", inversedBy="fillingTypeProfiles")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    private $profile;

    /**
     * @var integer
     */
    private $profile_id;

    /**
     * @var FillingType
     *
     * @ORM\ManyToOne(targetEntity="FillingType", inversedBy="fillingTypeProfiles")
     * @ORM\JoinColumn(name="filling_type_id", referencedColumnName="id")
     */
    private $fillingType;

    /**
     * @ORM\Column(name="is_default", type="boolean", nullable=false)
     * @Serializer\Expose
     */
    private $isDefault = false;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_grids", type="text", length=8192, nullable=true)
     * @Serializer\Expose
     */
    private $pricing_grids;

    /**
     * @var string
     *
     * @ORM\Column(name="pricing_equation_params", type="text", length=8192, nullable=true)
     * @Serializer\Expose
     */
    protected $pricing_equation_params;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param Profile $profile
     * @return self
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @return int
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("profile_id")
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
     * @param int $profile_id
     * @return self
     */
    public function setProfileId($profile_id)
    {
        $this->profile_id = $profile_id;
        return $this;
    }

    /**
     * @return FillingType
     */
    public function getFillingType()
    {
        return $this->fillingType;
    }

    /**
     * @param FillingType $fillingType
     * @return self
     */
    public function setFillingType(FillingType $fillingType)
    {
        $this->fillingType = $fillingType;
        return $this;
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
}
