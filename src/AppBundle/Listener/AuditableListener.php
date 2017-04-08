<?php
namespace AppBundle\Listener;

use AppBundle\Model\AuditableInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuditableListener
{
    private $userToken;

    public function __construct(TokenStorageInterface $userToken)
    {
        $this->userToken = $userToken;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        if (php_sapi_name() != "cli") { // disable listener when run from CLI
            $token = $this->userToken->getToken(); //to prevent fatal error while sending request for registration
            if(!$token) {
                return;
            }
            $user = $token->getUser();
            $entity = $args->getEntity();
            // $entityManager = $args->getEntityManager();

            // Check Interface "AuditableInterface" entity
            if (!$entity instanceof AuditableInterface) {
                return;
            }

//            $em = $args->getEntityManager();
//            $auditSubject = $em->getRepository("AppBundle:User")->find($user->getId());
            // Do some "magic" before update DB
            $entity->updateAuditFields($user);
        }
    }
}
