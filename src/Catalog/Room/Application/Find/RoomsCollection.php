<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Model\Room;

final readonly class RoomsCollection
{
    /**
     * @param iterable<Room> $rooms
     */
    public function __construct(
        public iterable $rooms,
    ) {
    }
}
