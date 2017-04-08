<?php

namespace AppBundle\Model;

use AppBundle\Entity\Quote;

/**
 * Class QuoteCollection
 */
class QuoteCollection extends Collection
{
    /**
     * @var Quote[]
     */
    public $quotes;

    /**
     * @param Quote[] $quotes
     * @param int     $offset
     * @param int     $limit
     */
    public function __construct(array $quotes, $offset, $limit)
    {
        parent::__construct($offset, $limit);

        $this->quotes = $quotes;
    }
}
