<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Get;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomState;

final readonly class RoomView
{
    public function __construct(
        public string $id,
        public RoomNumberView $number,
        public RoomState $state,
        public \DateTimeImmutable $createdAt,
        public ?\DateTimeImmutable $updatedAt = null,
    ) {
    }

    public static function fromModel(Room $room): self
    {
        return new self(
            $room->id->value,
            RoomNumberView::fromModel($room->number),
            $room->state,
            $room->createdAt,
            $room->updatedAt,
        );
    }
}
