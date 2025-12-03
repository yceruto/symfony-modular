<?php

declare(strict_types=1);

namespace App\Catalog\Room\Presentation\Http\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Catalog\Room\Presentation\Http\Operation\Patch\PatchRoomPayload;
use App\Catalog\Room\Presentation\Http\Operation\Patch\PatchRoomProcessor;
use App\Catalog\Room\Presentation\Http\Operation\Post\CreateRoomPayload;
use App\Catalog\Room\Presentation\Http\Operation\Post\CreateRoomProcessor;
use App\Catalog\Room\Presentation\Http\Operation\Delete\DeleteRoomProcessor;
use App\Catalog\Room\Presentation\Http\Operation\Get\RoomProvider;
use App\Catalog\Room\Presentation\Http\Operation\Get\RoomView;
use App\Catalog\Room\Presentation\Http\Operation\GetCollection\RoomCollectionProvider;
use App\Catalog\Room\Presentation\Http\Operation\GetCollection\RoomItemView;

#[ApiResource(
    shortName: 'rooms',
    operations: [
        new GetCollection(
            output: RoomItemView::class,
            provider: RoomCollectionProvider::class,
        ),
        new Post(
            input: CreateRoomPayload::class,
            output: RoomView::class,
            processor: CreateRoomProcessor::class,
        ),
        new Get(
            uriTemplate: '/rooms/{id}',
            uriVariables: ['id'],
            output: RoomView::class,
            provider: RoomProvider::class,
        ),
        new Delete(
            uriTemplate: '/rooms/{id}',
            uriVariables: ['id'],
            provider: RoomProvider::class,
            processor: DeleteRoomProcessor::class,
        ),
        new Patch(
            uriTemplate: '/rooms/{id}',
            uriVariables: ['id'],
            input: PatchRoomPayload::class,
            output: RoomView::class,
            provider: RoomProvider::class,
            processor: PatchRoomProcessor::class,
        ),
    ],
)]
final class RoomResource
{
}
