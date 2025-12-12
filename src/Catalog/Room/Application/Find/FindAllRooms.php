<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use OpenSolid\Shared\Application\Query\Query;

/**
 * @template-extends Query<RoomCollection>
 */
final readonly class FindAllRooms extends Query
{
}
