<?php

declare(strict_types=1);

namespace App\Catalog\Room\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class RoomNumber implements \Stringable
{
    public static function create(int $floor, int $door): self
    {
        return new self($floor, $door);
    }

    public function __toString(): string
    {
        return \sprintf('%d%d', $this->floor, $this->door);
    }

    private function __construct(
        #[Column]
        private(set) int $floor,

        #[Column]
        private(set) int $door,
    ) {
    }
}
