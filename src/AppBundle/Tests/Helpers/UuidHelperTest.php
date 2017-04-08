<?php

namespace AppBundle\Tests\Helpers;

use AppBundle\Helpers\UuidHelper;

/**
 * Class UuidHelper
 */
class UuidHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testUuidHelperCreatesValidUuid()
    {
        $uuid = UuidHelper::NewUuid();

        $this->assertTrue(UuidHelper::isValidUuid($uuid));
    }

    public function testInvalidUuid()
    {
        $this->assertFalse(UuidHelper::isValidUuid('invalid'));
    }
}
