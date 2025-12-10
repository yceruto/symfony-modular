<?php

namespace App\Catalog\Room\Domain\Model;

use App\Shared\Domain\Model\Id;

class RoomId extends Id
{
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
