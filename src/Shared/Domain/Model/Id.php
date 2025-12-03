<?php

namespace App\Shared\Domain\Model;

use Symfony\Component\Uid\Uuid;

class Id implements \Stringable
{
    private(set) string $value;

    public function __construct()
    {
        $this->value = Uuid::v7()->toRfc4122();
    }

    public static function fromString(string $value): static
    {
        $self = new static();
        $self->value = Uuid::fromString($value)->toRfc4122();

        return $self;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
