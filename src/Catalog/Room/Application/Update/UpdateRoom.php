<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Update;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Model\RoomStatus;
use OpenSolid\Cqs\Command\Command;

/**
 * @template-extends Command<Room>
 */
final readonly class UpdateRoom extends Command
{
    public function __construct(
        public RoomId $id,
        public RoomStatus $status,
    ) {
    }
}
