<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use OpenSolid\Cqs\Query\Query;

/**
 * @template-extends Query<RoomsCollection>
 */
final readonly class FindAllRooms extends Query
{
}
