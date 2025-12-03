<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Repository\RoomRepository;
use OpenSolid\Cqs\Query\Query;
use OpenSolid\CqsBundle\Attribute\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindAllRoomsHandler extends Query
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
