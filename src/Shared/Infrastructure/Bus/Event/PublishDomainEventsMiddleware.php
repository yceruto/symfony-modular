<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Event;

use Doctrine\ORM\EntityManagerInterface;
use OpenSolid\Domain\Event\Bus\EventBus;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

#[AsAlias('publish_domain_events')]
final readonly class PublishDomainEventsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EventBus $eventBus,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $envelope = $stack->next()->handle($envelope, $stack);

        foreach ($this->entityManager->getUnitOfWork()->getIdentityMap() as $entities) {
            foreach ($entities as $entity) {
                if (method_exists($entity, 'pullDomainEvents')) {
                    $this->eventBus->publish(...$entity->pullDomainEvents());
                }
            }
        }

        return $envelope;
    }
}
