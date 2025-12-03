<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Model;

use App\Catalog\Room\Domain\Event\RoomCreated;
use App\Catalog\Room\Domain\Event\RoomUpdated;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use OpenSolid\Domain\Event\Store\InMemoryEventStoreTrait;

#[Entity]
class Room
{
    use InMemoryEventStoreTrait;

    #[Id, Column]
    private(set) RoomId $id;

    #[Embedded]
    private(set) RoomNumber $number;

    #[Column]
    private(set) RoomStatus $status;

    #[Column]
    private(set) \DateTimeImmutable $createdAt;

    #[Column(nullable: true)]
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

    public function updateStatus(RoomStatus $status): void
    {
        if ($this->status->equals($status)) {
            return;
        }

        $this->status = $status;
        $this->updatedAt = new \DateTimeImmutable();

        $this->pushDomainEvent(new RoomUpdated($this->id->value, $status));
    }

    // rich model with behavior ...
}
