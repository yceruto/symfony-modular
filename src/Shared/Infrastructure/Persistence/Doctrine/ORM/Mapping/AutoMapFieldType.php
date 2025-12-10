<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine\ORM\Mapping;

use App\Shared\Domain\Model\Uid;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(Events::loadClassMetadata)]
final readonly class AutoMapFieldType
{
    /**
     * @param array<class-string> $types
     */
    public function __construct(
        private array $types = [Uid::class],
    ) {
    }

    public function __invoke(LoadClassMetadataEventArgs $args): void
    {
        $classMetadata = $args->getClassMetadata();
        $reflectionClass = $classMetadata->getReflectionClass();

        foreach ($classMetadata->getFieldNames() as $fieldName) {
            $mapping = $classMetadata->getFieldMapping($fieldName);

            if ($mapping->declaredField && isset($classMetadata->embeddedClasses[$mapping->declaredField])) {
                continue;
            }

            $propertyType = $reflectionClass->getProperty($fieldName)->getType()?->getName();

            if (!$propertyType || !\class_exists($propertyType)) {
                continue;
            }

            foreach ($this->types as $type) {
                if (\is_subclass_of($propertyType, $type)) {
                    $classMetadata->fieldMappings[$fieldName]->type = $propertyType;

                    continue 2;
                }
            }
        }
    }
}
