<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Create;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Model\RoomNumber;
use App\Catalog\Room\Domain\Model\RoomState;
use OpenSolid\Shared\Application\Command\Command;

/**
 * @template-extends Command<Room>
 */
final readonly class CreateRoom extends Command
{
    public function __construct(
        public RoomId $id,
        public RoomNumber $number,
        public RoomState $state,
    ) {
    }
}
