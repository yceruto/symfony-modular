<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Console\Create;

use App\Catalog\Room\Domain\Model\RoomState;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\Ask;

class CreateRoomInput
{
    #[Argument, Ask('The floor of the room')]
    public int $floor;

    #[Argument, Ask('The door of the room')]
    public int $door;

    #[Argument, Ask('The state of the room (available, occupied, under-maintenance)')]
    public RoomState $state;
}
