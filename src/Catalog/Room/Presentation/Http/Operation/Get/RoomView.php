<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Operation\Get;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomStatus;

final readonly class RoomView
{
    public function __construct(
        public string $id,
        public RoomNumberView $number,
        public RoomStatus $status,
    ) {
    }

    public static function fromModel(Room $room): self
    {
        return new self(
            $room->id->value(),
            RoomNumberView::fromModel($room->number),
            $room->status,
        );
    }
}
