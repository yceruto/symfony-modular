<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Error;

use OpenSolid\Domain\Error\EntityNotFound;

final class RoomNotFound extends EntityNotFound
{
    protected const string DEFAULT_MESSAGE = 'Room not found';
}
