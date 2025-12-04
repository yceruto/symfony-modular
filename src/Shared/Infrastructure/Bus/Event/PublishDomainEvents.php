<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use OpenSolid\Domain\Event\Bus\EventBus;

#[AsDoctrineListener(event: Events::postPersist)]
#[AsDoctrineListener(event: Events::postUpdate)]
#[AsDoctrineListener(event: Events::postRemove)]
final readonly class PublishDomainEvents
{
    public function __construct(
        private EventBus $eventBus,
    ) {
    }

    public function __invoke(LifecycleEventArgs $event): void
    {
        $entity = $event->getObject();

        if (method_exists($entity, 'pullDomainEvents')) {
            $this->eventBus->publish(...$entity->pullDomainEvents());
        }
    }
}
