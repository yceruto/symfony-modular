<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Delete;

use App\Catalog\Room\Application\Find\RoomFinder;
use App\Catalog\Room\Domain\Repository\RoomRepository;
use OpenSolid\CqsBundle\Attribute\AsCommandHandler;

#[AsCommandHandler]
final readonly class DeleteRoomHandler
{
    public function __construct(
        private RoomFinder $finder,
        private RoomRepository $repository,
    ) {
    }

    public function __invoke(DeleteRoom $command): void
    {
        $room = $this->finder->findOne($command->id);

        $this->repository->remove($room);
    }
}
