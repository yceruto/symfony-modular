<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DbalTypesPass implements CompilerPassInterface
{
    private array $resourceIds = [];

    public function __construct(
        private readonly ContainerBuilder $container,
    ) {
    }

    /**
     * @param class-string<Type> $dbalType The DBAL type class
     */
    public function registerForAutoconfiguration(string $dbalType): self
    {
        if (!\class_exists($dbalType)) {
            throw new \LogicException(\sprintf('Class "%s" does not exist.', $dbalType));
        }

        $methodReturnType = new \ReflectionClass($dbalType)->getMethod('convertToPHPValue')->getReturnType();

        if (!$methodReturnType instanceof \ReflectionNamedType) {
            throw new \LogicException(\sprintf(''));
        }

        $class = $methodReturnType->getName();

        $this->container->registerForAutoconfiguration($class)
            ->addResourceTag($class, ['type' => $dbalType]);

        $this->resourceIds[] = $class;

        return $this;
    }

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('doctrine.dbal.connection_factory.types')) {
            return;
        }

        $typeDefinition = $container->getParameter('doctrine.dbal.connection_factory.types');

        foreach ($this->resourceIds as $resourceId) {
            foreach ($container->findTaggedResourceIds($resourceId, false) as $id => $attributes) {
                if (!\class_exists($id)) {
                    continue;
                }

                $typeDefinition[$id] = ['class' => $attributes[0]['type']];
            }
        }

        $container->setParameter('doctrine.dbal.connection_factory.types', $typeDefinition);
    }
}
