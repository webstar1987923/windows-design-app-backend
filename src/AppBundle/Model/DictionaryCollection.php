<?php
namespace AppBundle\Model;
use AppBundle\Entity\Dictionary;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;

/**
 * Class DictionaryCollection
 * @package AppBundle\Model
 * @ExclusionPolicy("all")
 */
class DictionaryCollection
{
  /**
   * @var Dictionary[]
   * @Groups({"dictionary-list"})
   * @Expose
   */
  public $dictionaries;

  /**
   * @var integer
   * @Groups({"dictionary-list"})
   * @Expose
   */
  public $offset;

  /**
   * @var integer
   * @Groups({"dictionary-list"})
   * @Expose
   */
  public $limit;
  /**
   * @param Dictionary[]  $items
   * @param integer $offset
   * @param integer $limit
   */
  public function __construct($items = array(), $offset = null, $limit = null)
  {
    $this->dictionaries = $items;
    $this->offset = $offset;
    $this->limit = $limit;
  }
}
