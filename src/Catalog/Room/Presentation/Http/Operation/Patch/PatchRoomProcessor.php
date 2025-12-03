<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Operation\Patch;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Room\Application\Create\CreateRoom;
use App\Catalog\Room\Application\Update\UpdateRoom;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Model\RoomNumber;
use App\Catalog\Room\Presentation\Http\Operation\Get\RoomView;
use OpenSolid\Cqs\Command\CommandBus;

final readonly class PatchRoomProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): RoomView
    {
        assert($data instanceof PatchRoomPayload);

        $command = new UpdateRoom(
            id: RoomId::fromString($uriVariables['id']),
            status: $data->status,
        );

        $room = $this->commandBus->execute($command);

        return RoomView::fromModel($room);
    }
}
