<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class DbalTypesPass implements CompilerPassInterface
{
    public function __construct(
        private array $resourceIds,
    ) {
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
