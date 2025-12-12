<?php

declare(strict_types=1);

namespace App\Catalog\Room\Infrastructure\Logging;

use App\Catalog\Room\Domain\Event\RoomCreated;
use OpenSolid\Shared\Infrastructure\Event\Subscriber\Attribute\AsDomainEventSubscriber;
use Psr\Log\LoggerInterface;

#[AsDomainEventSubscriber]
final readonly class RoomCreatedSubscriber
{
    public function __construct(
        private LoggerInterface $logger,
    ) {
    }

    public function __invoke(RoomCreated $event): void
    {
        $this->logger->info(\sprintf('Room "%s" has been created.', $event->aggregateId));
    }
}
