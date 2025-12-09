<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Type;

use App\Shared\Domain\Model\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;

class IdType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Id
    {
        $class = $this->getIdClass();

        if (\is_a($value, $class) || null === $value) {
            return $value;
        }

        if (!\is_string($value)) {
            throw InvalidType::new($value, $class, ['null', 'string', $class]);
        }

        try {
            return $class::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ValueNotConvertible::new($value, $class, previous: $e);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        $class = $this->getIdClass();

        if (\is_a($value, $class)) {
            return $value->value;
        }

        if (null === $value || '' === $value) {
            return null;
        }

        if (!\is_string($value)) {
            throw InvalidType::new($value, $class, ['null', 'string', $class]);
        }

        try {
            return $class::fromString($value)->value;
        } catch (\InvalidArgumentException $e) {
            throw ValueNotConvertible::new($value, $class, previous: $e);
        }
    }

    /**
     * @return class-string<Id>
     */
    private function getIdClass(): string
    {
        return self::lookupName($this);
    }
}
