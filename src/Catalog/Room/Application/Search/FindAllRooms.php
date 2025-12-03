<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Search;

use OpenSolid\Cqs\Query\Query;

/**
 * @template-extends Query<RoomsCollection>
 */
final readonly class FindAllRooms extends Query
{
}
