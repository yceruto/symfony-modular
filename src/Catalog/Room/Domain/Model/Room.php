<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Model;

use App\Catalog\Room\Domain\Error\InvalidRoomState;
use App\Catalog\Room\Domain\Event\RoomCreated;
use App\Catalog\Room\Domain\Event\RoomUpdated;
use OpenSolid\Shared\Domain\Error\Store\InMemoryErrorStore;
use OpenSolid\Shared\Domain\Event\Store\InMemoryEventStore;

class Room
{
    use InMemoryEventStore;
    use InMemoryErrorStore;

    private(set) RoomId $id;
    private(set) RoomNumber $number;
    private(set) RoomState $state;
    private(set) \DateTimeImmutable $createdAt;
    private(set) ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        RoomId $id,
        RoomNumber $number,
        RoomState $state,
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->state = $state;
        $this->createdAt = new \DateTimeImmutable();

        $this->pushDomainEvent(new RoomCreated($this->id->value));
    }

    public function setState(RoomState $state): void
    {
        if ($this->state->equals($state)) {
            return;
        }

        if (!$this->state->canTransitionTo($state)) {
            throw InvalidRoomState::create(\sprintf('Room "%s" cannot transition from "%s" to "%s".', $this->number, $this->state->value, $state->value));
        }

        $this->state = $state;
        $this->updatedAt = new \DateTimeImmutable();

        $this->pushDomainEvent(new RoomUpdated($this->id->value, $state));
    }

    // rich model with behavior ...
}
