<?php
namespace AppBundle\Model;


interface TimestampableInterface
{
    /**
     * Returns createdAt value.
     *
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * Returns updatedAt value.
     *
     * @return \DateTime
     */
    public function getUpdatedAt();

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setCreatedAt(\DateTime $value);

    /**
     * @param \DateTime $value
     * @return $this
     */
    public function setUpdatedAt(\DateTime $value);

    /**
     * Updates createdAt and updatedAt timestamps.
     */
    public function updateTimestamps();
}
