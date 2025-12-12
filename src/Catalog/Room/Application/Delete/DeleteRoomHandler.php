<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Delete;

use App\Catalog\Room\Application\Find\RoomFinder;
use App\Catalog\Room\Domain\Repository\RoomRepository;
use OpenSolid\Shared\Application\Command\Attribute\AsCommandHandler;

#[AsCommandHandler]
final readonly class DeleteRoomHandler
{
    public function __construct(
        private RoomFinder $finder,
        private RoomRepository $rooms,
    ) {
    }

    public function __invoke(DeleteRoom $command): void
    {
        $room = $this->finder->findOne($command->id);

        $this->rooms->remove($room);
    }
}
