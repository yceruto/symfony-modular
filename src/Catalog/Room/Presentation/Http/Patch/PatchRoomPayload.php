<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Patch;

use App\Catalog\Room\Domain\Model\RoomState;
use Symfony\Component\Validator\Constraints as Assert;

final class PatchRoomPayload
{
    #[Assert\NotNull]
    public RoomState $state;
}
