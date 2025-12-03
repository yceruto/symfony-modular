<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Create;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Repository\RoomRepository;
use OpenSolid\CqsBundle\Attribute\AsCommandHandler;

#[AsCommandHandler]
final readonly class CreateRoomHandler
{
    public function __construct(
        private RoomRepository $repository,
    ) {
    }

    public function __invoke(CreateRoom $command): Room
    {
        $room = new Room(
            $command->id,
            $command->number,
            $command->status,
        );

        $this->repository->add($room);

        return $room;
    }
}
