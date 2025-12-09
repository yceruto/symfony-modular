<?php

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

class Id implements \Stringable
{
    public static function create(): static
    {
        return new static(Uuid::v7()->toRfc4122());
    }

    public static function fromString(string $value): static
    {
        return new static(Uuid::fromString($value)->toRfc4122());
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function __construct(
        private(set) string $value,
    ) {
    }
}
