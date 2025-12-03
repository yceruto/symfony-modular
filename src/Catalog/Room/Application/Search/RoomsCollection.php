<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Search;

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
