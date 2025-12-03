<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\DBAL\Type;

use App\Shared\Domain\Model\Id;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Exception\ValueNotConvertible;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\Uuid;

class UidType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        if ($this->hasNativeGuidType($platform)) {
            return $platform->getGuidTypeDeclarationSQL($column);
        }

        return $platform->getBinaryTypeDeclarationSQL([
            'length' => 16,
            'fixed' => true,
        ]);
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?Id
    {
        $class = $this->getClass();

        if (\is_a($value, $class) || null === $value) {
            return $value;
        }

        if (!\is_string($value)) {
            throw InvalidType::new($value, $class, ['null', 'string', Id::class]);
        }

        try {
            return $class::fromString($value);
        } catch (\InvalidArgumentException $e) {
            throw ValueNotConvertible::new($value, $class, previous: $e);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        $class = $this->getClass();

        if (\is_a($value, $class)) {
            return $this->toString($value, $platform);
        }

        if (null === $value || '' === $value) {
            return null;
        }

        if (!\is_string($value)) {
            throw InvalidType::new($value, $class, ['null', 'string', Id::class]);
        }

        try {
            return $this->toString($class::fromString($value), $platform);
        } catch (\InvalidArgumentException $e) {
            throw ValueNotConvertible::new($value, $class, previous: $e);
        }
    }

    private function toString(Id $id, AbstractPlatform $platform): string
    {
        if ($this->hasNativeGuidType($platform)) {
            return $id->value;
        }

        return Uuid::fromString($id->value)->toBinary();
    }

    private function hasNativeGuidType(AbstractPlatform $platform): bool
    {
        return $platform->getGuidTypeDeclarationSQL([]) !== $platform->getStringTypeDeclarationSQL(['fixed' => true, 'length' => 36]);
    }

    /**
     * @return class-string<Id>
     */
    private function getClass(): string
    {
        return self::lookupName($this);
    }
}
