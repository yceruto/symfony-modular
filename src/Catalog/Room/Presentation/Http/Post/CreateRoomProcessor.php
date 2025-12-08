<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Post;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Room\Application\Create\CreateRoom;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Model\RoomNumber;
use App\Catalog\Room\Presentation\Http\Get\RoomView;
use OpenSolid\Cqs\Command\CommandBus;

final readonly class CreateRoomProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RoomView
    {
        assert($data instanceof CreateRoomPayload);

        $command = new CreateRoom(
            id: $data->id ? RoomId::fromString($data->id) : new RoomId(),
            number: new RoomNumber($data->floor, $data->door),
            status: $data->status,
        );

        $room = $this->commandBus->execute($command);

        return RoomView::fromModel($room);
    }
}
