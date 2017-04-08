<?php
namespace AppBundle\Helpers;

use FOS\RestBundle\Request\ParamFetcherInterface;

class ParamFetcherHelper
{
    public static function getLimitAndOffset(ParamFetcherInterface $paramFetcher) {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');
        $limit = 0 == $limit ? null : $limit; // when 0 - then  unlimited

        return [$limit,$offset];
    }
}
