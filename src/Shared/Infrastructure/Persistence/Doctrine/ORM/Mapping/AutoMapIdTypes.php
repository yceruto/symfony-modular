<?php

namespace App\Shared\Infrastructure\Persistence\Doctrine\ORM\Mapping;

use App\Shared\Domain\Model\Id;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(Events::loadClassMetadata)]
final readonly class AutoMapIdTypes
{
    public function __construct(
        private string $idClass = Id::class,
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

            if (!$type || !\class_exists($type) || !\is_subclass_of($type, $this->idClass)) {
                continue;
            }

            $classMetadata->fieldMappings[$fieldName]->type = $type;
        }
    }
}
