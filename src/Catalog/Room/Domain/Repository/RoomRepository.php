<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Repository;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;

interface RoomRepository
{
    public function add(Room $room): void;

    public function remove(Room $room): void;

    public function ofId(RoomId $id): ?Room;

    public function all(): iterable;
}
