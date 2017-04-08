<?php
namespace AppBundle\Listener;

use AppBundle\Model\TimestampableInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TimestampableListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // $entityManager = $args->getEntityManager();

        // Check Interface "TimestampableInterface" entity
        if (!$entity instanceof TimestampableInterface) { return; }

        // Do some "magic" before update DB
        $entity->updateTimestamps();
    }
}
