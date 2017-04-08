<?php
namespace AppBundle\Tests\Controller\Rest;

class JwtAuthTest extends RestTestCase
{
    public function testGetCorrectJwtToken() {
        $client = $this->createAuthenticatedClient();
    }

    public function testJwtKeysExists() {
        $client = static::createClient();
        $private_key = $client->getContainer()->getParameter('jwt_private_key_path');
        $this->assertFileExists($private_key, 'JWT Private key does not exists');
        $public_key = $client->getContainer()->getParameter('jwt_public_key_path');
        $this->assertFileExists($public_key, 'JWT Public key does not exists');
    }
}
