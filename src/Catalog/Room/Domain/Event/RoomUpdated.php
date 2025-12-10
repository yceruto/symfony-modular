<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Event;

use App\Catalog\Room\Domain\Model\RoomState;
use OpenSolid\Domain\Event\DomainEvent;

final readonly class RoomUpdated extends DomainEvent
{
    public function __construct(
        string $aggregateId,
        public RoomState $state,
    ) {
        parent::__construct($aggregateId);
    }
}
