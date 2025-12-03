<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Resource;

use ApiPlatform\Metadata\ApiResource;
use App\Catalog\Room\Domain\Model\RoomNumber;
use App\Catalog\Room\Domain\Model\RoomStatus;

#[ApiResource(
    shortName: 'rooms',
)]
class RoomResource
{
    public string $id;

    public RoomNumber $number;

    public RoomStatus $status;
}
