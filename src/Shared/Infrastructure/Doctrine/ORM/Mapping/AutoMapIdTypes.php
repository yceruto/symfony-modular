<?php

namespace App\Shared\Infrastructure\Doctrine\ORM\Mapping;

use App\Shared\Domain\Model\Id;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(Events::loadClassMetadata)]
class AutoMapIdTypes
{
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

            if (!$type || !\class_exists($type) || !\is_subclass_of($type, Id::class)) {
                continue;
            }

            $classMetadata->fieldMappings[$fieldName]->type = $type;
        }
    }
}
