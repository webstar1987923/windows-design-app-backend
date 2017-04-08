<?php
namespace AppBundle\Model;
use AppBundle\Entity\Profile;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Class ProfileCollection
 * @package AppBundle\Model
 * @ExclusionPolicy("all")
 */
class ProfileCollection
{
    /**
     * @var Profile[]
     * @Groups({"profile-list"})
     * @Expose
     */
    public $profiles;
    
    /**
     * @var integer
     * @Groups({"profile-list"})
     * @Expose
     */
    public $offset;

    /**
     * @var integer
     * @Groups({"profile-list"})
     * @Expose
     */
    public $limit;
    /**
     * @param Profile[]  $profiles
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($profiles = array(), $offset = null, $limit = null)
    {
        $this->profiles = $profiles;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
