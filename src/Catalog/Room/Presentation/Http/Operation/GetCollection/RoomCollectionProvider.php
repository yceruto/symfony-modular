<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Operation\GetCollection;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Catalog\Room\Application\Find\FindAllRooms;
use App\Catalog\Room\Domain\Model\Room;
use OpenSolid\Cqs\Query\QueryBus;

final readonly class RoomCollectionProvider implements ProviderInterface
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    /**
     * @return array<RoomItemView>|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?array
    {
        $collection = $this->queryBus->ask(new FindAllRooms());

        return array_map(fn (Room $room) => RoomItemView::fromModel($room), $collection->items);
    }
}
