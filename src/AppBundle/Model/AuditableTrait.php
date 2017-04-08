<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

use AppBundle\Entity\User;

/**
 * Auditable trait.
 *
 * Should be used inside entity, that needs to be audited.
 *
 * @ExclusionPolicy("all")
 */
trait AuditableTrait
{
    /**
     * @var User
     * @Type("AppBundle\Entity\User")
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id", nullable=false)
     * @Expose
     */
    protected $createdBy;

    /**
     * @var User
     * @Type("AppBundle\Entity\User")
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by_id", referencedColumnName="id", nullable=false)
     * @Expose
     */
    protected $updatedBy;

    /**
     * Returns createdBy value.
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Returns updatedBy value.
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param User $value
     * @return $this
     */
    public function setCreatedBy(User $value)
    {
        $this->createdBy = $value;
        return $this;
    }

    /**
     * @param User $value
     * @return $this
     */
    public function setUpdatedBy(User $value)
    {
        $this->updatedBy = $value;
        return $this;
    }

    /**
     * Updates createdBy and updatedBy timestamps.
     * @param User $value
     */
    public function updateAuditFields(User $value)
    {
        if (null === $this->createdBy) {
            $this->createdBy = $value;
        }

        $this->updatedBy = $value;
    }
}
