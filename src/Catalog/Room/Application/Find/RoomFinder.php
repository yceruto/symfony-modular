<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Error\RoomNotFound;
use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Repository\RoomRepository;

final readonly class RoomFinder
{
    public function __construct(
        private RoomRepository $rooms,
    ) {
    }

    public function findOne(RoomId $id): Room
    {
        return $this->rooms->ofId($id) ?? throw RoomNotFound::create();
    }

    /**
     * @return iterable<Room>
     */
    public function findAll(): iterable
    {
        return $this->rooms->all();
    }
}
