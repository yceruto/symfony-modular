<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Model;

use App\Catalog\Room\Domain\Error\InvalidRoomState;
use App\Catalog\Room\Domain\Event\RoomCreated;
use App\Catalog\Room\Domain\Event\RoomUpdated;
use OpenSolid\Domain\Error\Store\InMemoryErrorStoreTrait;
use OpenSolid\Domain\Event\Store\InMemoryEventStoreTrait;

class Room
{
    use InMemoryEventStoreTrait;
    use InMemoryErrorStoreTrait;

    private(set) RoomId $id;
    private(set) RoomNumber $number;
    private(set) RoomStatus $status;
    private(set) \DateTimeImmutable $createdAt;
    private(set) ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        RoomId $id,
        RoomNumber $number,
        RoomStatus $status,
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->status = $status;
        $this->createdAt = new \DateTimeImmutable();

        $this->pushDomainEvent(new RoomCreated($this->id->value));
    }

    public function setStatus(RoomStatus $status): void
    {
        if ($this->status->equals($status)) {
            return;
        }

        if (!$this->status->canTransitionTo($status)) {
            throw InvalidRoomState::create(\sprintf('Room "%s" cannot transition from "%s" to "%s".', $this->number, $this->status->value, $status->value));
        }

        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();

        $this->pushDomainEvent(new RoomUpdated($this->id->value, $status));
    }

    // rich model with behavior ...
}
