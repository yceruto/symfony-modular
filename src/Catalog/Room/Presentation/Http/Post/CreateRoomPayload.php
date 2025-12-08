<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Post;

use App\Catalog\Room\Domain\Model\RoomStatus;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateRoomPayload
{
    #[Assert\Uuid]
    public ?string $id = null;

    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    public int $floor;

    #[Assert\NotNull]
    #[Assert\GreaterThan(0)]
    public int $door;

    #[Assert\NotNull]
    public RoomStatus $status;
}
