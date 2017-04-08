<?php
namespace AppBundle\Model;
use AppBundle\Entity\Project;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

class ProjectCollection
{
    /**
     * @var Project[]
     * @ExclusionPolicy("all")
     * @Groups({"list", "details"})
     * @Expose
     */
    public $projects;
    /**
     * @var integer
     */
    public $offset;
    /**
     * @var integer
     */
    public $limit;
    /**
     * @param Project[]  $projects
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($projects = array(), $offset = null, $limit = null)
    {
        $this->projects = $projects;
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
