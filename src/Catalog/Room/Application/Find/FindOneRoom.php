<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Find;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;
use OpenSolid\Cqs\Query\Query;

/**
 * @template-extends Query<Room>
 */
final readonly class FindOneRoom extends Query
{
    public function __construct(
        public RoomId $id,
    ) {
    }
}
