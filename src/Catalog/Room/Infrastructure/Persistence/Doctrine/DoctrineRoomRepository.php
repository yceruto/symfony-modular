<?php

declare(strict_types=1);

namespace App\Catalog\Room\Infrastructure\Persistence\Doctrine;

use App\Catalog\Room\Domain\Model\Room;
use App\Catalog\Room\Domain\Model\RoomId;
use App\Catalog\Room\Domain\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class DoctrineRoomRepository implements RoomRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function add(Room $room): void
    {
        $this->entityManager->persist($room);
    }

    public function remove(Room $room): void
    {
        $this->entityManager->remove($room);
    }

    public function ofId(RoomId $id): ?Room
    {
        return $this->entityManager->find(Room::class, $id);
    }

    public function all(): iterable
    {
        return $this->entityManager->getRepository(Room::class)->findAll();
    }
}
