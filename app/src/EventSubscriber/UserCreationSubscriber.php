<?php

namespace App\EventSubscriber;

use App\Entity\Client;
use App\Services\DialotelAPI\DialotelServices;
use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserCreationSubscriber implements EventSubscriberInterface
{

    private DialotelServices $dialotelServices;

    public function __construct(DialotelServices $dialotelServices)
    {
        $this->dialotelServices = $dialotelServices;
    }

    public function onPostPersist($event): void
    {
        $entity = $event->getObject();

        if ($entity instanceof Client) {
            $this->dialotelServices->createCustomer($entity->getEmail());
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::postPersist => 'onPostPersist',
        ];
    }
}
