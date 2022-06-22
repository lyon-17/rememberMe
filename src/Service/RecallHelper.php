<?php

namespace App\Service;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Recall;
use App\Entity\Status;

class RecallHelper
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Recall) {
            $foo = $entityManager->getRepository(Status::class)->getMain();
            $entity->setState($foo);
            $entity->setStatus($foo->getName());
        }
    }
}