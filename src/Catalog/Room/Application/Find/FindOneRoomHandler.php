<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Model\Room;
use OpenSolid\Shared\Application\Query\Attribute\AsQueryHandler;

#[AsQueryHandler]
final readonly class FindOneRoomHandler
{
    public function __construct(
        private RoomFinder $finder,
    ) {
    }

    public function __invoke(FindOneRoom $query): Room
    {
        return $this->finder->findOne($query->id);
    }
}
