<?php

namespace App\Catalog\Room\Domain\Model;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case UNDER_MAINTENANCE = 'under-maintenance';

    public function isAvailable(): bool
    {
        return $this === self::AVAILABLE;
    }

    public function isOccupied(): bool
    {
        return $this === self::OCCUPIED;
    }

    public function isUnderMaintenance(): bool
    {
        return $this === self::UNDER_MAINTENANCE;
    }

    public function equals(self $other): bool
    {
        return $this === $other;
    }

    public function canTransitionTo(self $status): bool
    {
        $feasible = match ($this) {
            self::AVAILABLE => [self::OCCUPIED, self::UNDER_MAINTENANCE],
            self::OCCUPIED, self::UNDER_MAINTENANCE => [self::AVAILABLE],
        };

        return \in_array($status, $feasible, true);
    }
}
