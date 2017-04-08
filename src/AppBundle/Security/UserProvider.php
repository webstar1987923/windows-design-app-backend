<?php
namespace AppBundle\Security;

use FOS\UserBundle\Security\UserProvider as FOSUserProvider;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

class UserProvider extends FOSUserProvider
{
    public function refreshUser(SecurityUserInterface $user)
    {
        if (null === $reloadedUser = $this->userManager->findUserBy(array('id' => $user->getId()))) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }
}