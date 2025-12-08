<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Get;

use App\Catalog\Room\Domain\Model\RoomNumber;

final readonly class RoomNumberView
{
    public function __construct(
        public int $floor,
        public int $door,
    ) {
    }

    public static function fromModel(RoomNumber $number): self
    {
        return new self(
            $number->floor,
            $number->door,
        );
    }
}
