<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\GetCollection;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomState;

final readonly class RoomItemView
{
    public function __construct(
        public string $id,
        public string $number,
        public RoomState $state,
    ) {
    }

    public static function fromModel(Room $room): self
    {
        return new self(
            $room->id->value,
            (string) $room->number,
            $room->state,
        );
    }
}
