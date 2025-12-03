<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Search;

use App\Catalog\Room\Domain\Repository\RoomRepository;
use OpenSolid\Cqs\Query\Query;
use OpenSolid\CqsBundle\Attribute\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindAllRoomsHandler extends Query
{
    public function __construct(
        private RoomRepository $repository,
    ) {
    }

    public function __invoke(FindAllRooms $message): RoomsCollection
    {
        return new RoomsCollection($this->repository->all());
    }
}
