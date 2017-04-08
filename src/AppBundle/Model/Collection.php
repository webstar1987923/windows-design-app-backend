<?php

namespace AppBundle\Model;

/**
 * Class Collection
 */
abstract class Collection
{
    /**
     * @var integer
     */
    public $offset;

    /**
     * @var integer
     */
    public $limit;

    /**
     * @param integer $offset
     * @param integer $limit
     */
    public function __construct($offset = null, $limit = null)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }
}
