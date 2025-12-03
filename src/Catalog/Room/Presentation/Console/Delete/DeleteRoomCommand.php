<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Console\Delete;

use App\Catalog\Room\Application\Delete\DeleteRoom;
use App\Catalog\Room\Domain\Error\RoomNotFound;
use App\Catalog\Room\Domain\Model\RoomId;
use OpenSolid\Cqs\Command\CommandBus;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:delete-rooms')]
final readonly class DeleteRoomCommand
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(SymfonyStyle $io, #[Argument] string $id): int
    {
        $roomId = RoomId::fromString($id);

        try {
            $this->commandBus->execute(new DeleteRoom($roomId));
        } catch (RoomNotFound $exception) {
            $io->error($exception->getMessage());

            return 1;
        }

        $io->success('Room has been deleted.');

        return 0;
    }
}
