<?php
namespace AppBundle\Model;

use AppBundle\Entity\User;

interface AuditableInterface
{
    /**
     * Returns createdBy value.
     *
     * @return User
     */
    public function getCreatedBy();

    /**
     * Returns updatedBy value.
     *
     * @return User
     */
    public function getUpdatedBy();

    /**
     * @param User $value
     * @return $this
     */
    public function setCreatedBy(User $value);

    /**
     * @param User $value
     * @return $this
     */
    public function setUpdatedBy(User $value);

    /**
     * Updates createdBy and updatedBy timestamps.
     * @param User $value
     */
    public function updateAuditFields(User $value);
}
