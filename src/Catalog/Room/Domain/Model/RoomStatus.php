<?php

namespace App\Catalog\Room\Domain\Model;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case OUT_OF_ORDER = 'out-of-order';
    case UNDER_MAINTENANCE = 'under-maintenance';

    public function isAvailable(): bool
    {
        return $this === self::AVAILABLE;
    }

    public function isOccupied(): bool
    {
        return $this === self::OCCUPIED;
    }

    public function isOutOfOrder(): bool
    {
        return $this === self::OUT_OF_ORDER;
    }

    public function isUnderMaintenance(): bool
    {
        return $this === self::UNDER_MAINTENANCE;
    }

    public function equals(self $other): bool
    {
        return $this === $other;
    }
}
