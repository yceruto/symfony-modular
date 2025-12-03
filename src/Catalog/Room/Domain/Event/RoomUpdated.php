<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Event;

use App\Catalog\Room\Domain\Model\RoomStatus;
use OpenSolid\Domain\Event\DomainEvent;

final readonly class RoomUpdated extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        public RoomStatus $status,
    ) {
        parent::__construct($aggregateId);
    }
}
