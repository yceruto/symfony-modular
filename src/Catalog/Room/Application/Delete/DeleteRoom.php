<?php

declare(strict_types=1);

namespace App\Catalog\Room\Application\Delete;

use App\Catalog\Room\Domain\Model\RoomId;
use OpenSolid\Shared\Application\Command\Command;

/**
 * @template-extends Command<void>
 */
final readonly class DeleteRoom extends Command
{
    public function __construct(
        public RoomId $id,
    ) {
    }
}
