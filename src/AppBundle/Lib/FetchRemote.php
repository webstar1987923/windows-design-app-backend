<?php

namespace AppBundle\Lib;

// For easy functional testting
class FetchRemote
{
    public function fetch($url) {
        return file_get_contents($url);
    }
}