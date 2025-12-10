<?php

namespace App\Catalog\Room\Domain\Model;

use App\Shared\Domain\Model\Uid;

class RoomId extends Uid
{
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
