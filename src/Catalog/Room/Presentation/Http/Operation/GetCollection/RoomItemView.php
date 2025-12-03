<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Operation\GetCollection;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomStatus;

final readonly class RoomItemView
{
    public function __construct(
        public string $id,
        public string $number,
        public RoomStatus $status,
    ) {
    }

    public static function fromModel(Room $room): self
    {
        return new self(
            $room->id->value(),
            (string) $room->number,
            $room->status,
        );
    }
}
