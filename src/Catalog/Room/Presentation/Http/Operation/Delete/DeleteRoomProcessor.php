<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Operation\Delete;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Catalog\Room\Application\Delete\DeleteRoom;
use App\Catalog\Room\Domain\Model\RoomId;
use OpenSolid\Cqs\Command\CommandBus;

final readonly class DeleteRoomProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBus $commandBus,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): null
    {
        $id = RoomId::fromString($uriVariables['id']);

        $this->commandBus->execute(new DeleteRoom($id));

        return null;
    }
}
