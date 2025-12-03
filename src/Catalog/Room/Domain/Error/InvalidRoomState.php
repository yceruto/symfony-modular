<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Error;

use OpenSolid\Domain\Error\InvariantViolation;

final class InvalidRoomState extends InvariantViolation
{
}
