<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

#[Entity]
class Room
{
    public function __construct(
        #[Id, Column]
        private(set) RoomId $id,

        #[Embedded]
        private(set) RoomNumber $number,

        #[Column]
        private(set) RoomStatus $status,
    ) {
    }

    // rich model with behavior ...
}
