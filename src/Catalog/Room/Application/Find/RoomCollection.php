<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Model\Room;

final readonly class RoomCollection
{
    /**
     * @param iterable<Room> $items
     */
    public function __construct(
        public iterable $items,
    ) {
    }
}
