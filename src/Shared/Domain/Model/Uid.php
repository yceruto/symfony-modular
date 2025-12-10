<?php

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

abstract class Uid implements \Stringable
{
    public static function create(): static
    {
        return new static(Uuid::v7()->toRfc4122());
    }

    public static function fromString(string $value): static
    {
        return new static(Uuid::fromString($value)->toRfc4122());
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
