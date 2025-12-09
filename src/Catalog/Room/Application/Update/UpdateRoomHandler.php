<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Update;

use App\Catalog\Room\Application\Find\RoomFinder;
use App\Catalog\Room\Domain\Model\Room;
use OpenSolid\CqsBundle\Attribute\AsCommandHandler;

#[AsCommandHandler]
final readonly class UpdateRoomHandler
{
    public function __construct(
        private RoomFinder $finder,
    ) {
    }

    public function __invoke(UpdateRoom $command): Room
    {
        $room = $this->finder->findOne($command->id);
        $room->setStatus($command->status);

        return $room;
    }
}
