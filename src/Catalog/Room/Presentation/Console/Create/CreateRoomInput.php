<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Console\Create;

use App\Catalog\Room\Domain\Model\RoomStatus;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\Ask;

class CreateRoomInput
{
    #[Argument, Ask('The floor of the room')]
    public int $floor;

    #[Argument, Ask('The number of the room')]
    public int $apartment;

    #[Argument, Ask('The status of the room')]
    public RoomStatus $status;
}
