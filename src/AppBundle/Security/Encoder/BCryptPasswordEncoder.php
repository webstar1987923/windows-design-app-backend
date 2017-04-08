<?php

namespace AppBundle\Security\Encoder;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder as BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

/**
 * Class BCryptPasswordEncoder
 */
class BCryptPasswordEncoder extends BasePasswordEncoder
{
    /**
     * @var int
     */
    private $cost;

    /**
     * {@inheritdoc}
     */
    public function __construct($cost)
    {
        parent::__construct($cost);

        $this->cost = (int) $cost;
    }

    /**
     * {@inheritdoc}
     */
    public function encodePassword($raw, $salt = null)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }

        $options = array('cost' => $this->cost);

        return password_hash($raw, PASSWORD_BCRYPT, $options);
    }
}
