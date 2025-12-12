<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Console\Create;

use App\Catalog\Room\Application\Create\CreateRoom;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Model\RoomNumber;
use OpenSolid\Shared\Application\Command\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\MapInput;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:create-room')]
final readonly class CreateRoomCommand
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function __invoke(SymfonyStyle $io, #[MapInput] CreateRoomInput $input): int
    {
        $command = new CreateRoom(
            RoomId::create(),
            RoomNumber::create($input->floor, $input->door),
            $input->state,
        );

        $room = $this->commandBus->execute($command);

        $io->success(\sprintf('Room "%s" with ID "%s" has been created.', $room->number, $room->id));

        return 0;
    }
}
