<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Get;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Room\Application\Find\FindOneRoom;
use App\Catalog\Room\Domain\Model\RoomId;
use OpenSolid\Cqs\Query\QueryBus;

final readonly class RoomProvider implements ProviderInterface
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?RoomView
    {
        $id = RoomId::fromString($uriVariables['id']);

        $room = $this->queryBus->ask(new FindOneRoom($id));

        return RoomView::fromModel($room);
    }
}
