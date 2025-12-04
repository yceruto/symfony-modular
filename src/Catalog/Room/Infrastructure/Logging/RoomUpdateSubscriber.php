<?php

declare(strict_types=1);

namespace App\Catalog\Room\Infrastructure\Logging;

use App\Catalog\Room\Domain\Event\RoomUpdated;
use OpenSolid\DomainBundle\Attribute\AsDomainEventSubscriber;
use Psr\Log\LoggerInterface;

#[AsDomainEventSubscriber]
final readonly class RoomUpdateSubscriber
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(RoomUpdated $event): void
    {
        $this->logger->info(\sprintf('Room "%s" has been updated with status "%s".', $event->aggregateId, $event->status->value));
    }
}
