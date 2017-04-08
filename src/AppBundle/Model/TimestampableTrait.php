<?php

namespace AppBundle\Model;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Timestampable trait.
 *
 * Should be used inside entity, that needs to be timestamped.
 *
 * @ExclusionPolicy("all")
 */
trait TimestampableTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Expose
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Expose
     */
    protected $updatedAt;

    /**
     * Returns createdAt value.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Returns updatedAt value.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setCreatedAt(\DateTime $value)
    {
        $this->createdAt = $value;
        return $this;
    }

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setUpdatedAt(\DateTime $value)
    {
        $this->updatedAt = $value;
        return $this;
    }

    /**
     * Updates createdAt and updatedAt timestamps.
     */
    public function updateTimestamps()
    {
        if (null === $this->createdAt) {
            $this->createdAt = new \DateTime('now');
        }

        $this->updatedAt = new \DateTime('now');
    }
}
