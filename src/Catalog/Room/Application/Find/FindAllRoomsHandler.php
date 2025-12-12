<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use OpenSolid\Shared\Application\Query\Attribute\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindAllRoomsHandler
{
    public function __construct(
        private RoomFinder $finder,
    ) {
    }

    public function __invoke(FindAllRooms $query): RoomCollection
    {
        return new RoomCollection($this->finder->findAll());
    }
}
