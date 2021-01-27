<?php

namespace App\EventListener;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class EventSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents()
    {
        return [Events::prePersist];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Event && null === $entity->getCode()) {
            $repository = $args
                ->getEntityManager()
                ->getRepository(Event::class);

            $code = $this->generateCode();
            while (null !== $repository->findOneBy(['code' => $code])) {
                $code = $this->generateCode();
            }

            $entity->setCode($code);
        }
    }

    private function generateCode()
    {
        $length = 6;

        return sprintf(
            '%0' . $length . 'd',
            random_int(0, pow(10, $length) - 1)
        );
    }
}
