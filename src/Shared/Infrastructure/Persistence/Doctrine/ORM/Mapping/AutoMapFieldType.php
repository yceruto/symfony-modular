<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine\ORM\Mapping;

use App\Shared\Domain\Model\Id;
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
        private array $types = [Id::class],
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

            $type = $reflectionClass->getProperty($fieldName)->getType()?->getName();

            if (!$type || !\class_exists($type)) {
                continue;
            }

            foreach ($this->types as $superType) {
                if (\is_subclass_of($type, $superType)) {
                    $classMetadata->fieldMappings[$fieldName]->type = $type;

                    continue 2;
                }
            }
        }
    }
}
