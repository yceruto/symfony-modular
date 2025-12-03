<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Console\List;

use App\Catalog\Room\Application\Find\FindAllRooms;
use OpenSolid\Cqs\Query\QueryBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:list-rooms')]
final readonly class ListRoomCommand
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        $result = $this->queryBus->ask(new FindAllRooms());

        $rows = [];
        foreach ($result->rooms as $room) {
            $rows[] = [$room->id, $room->number, $room->status->value];
        }

        $io->title('List rooms');
        $io->table(['ID', 'Number', 'Status'], $rows);

        return 0;
    }
}
