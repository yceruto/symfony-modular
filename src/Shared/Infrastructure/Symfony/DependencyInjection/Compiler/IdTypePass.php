<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler;

use App\Shared\Domain\Model\Id;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Type\IdType;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final readonly class IdTypePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('doctrine.dbal.connection_factory.types')) {
            return;
        }

        $typeDefinition = $container->getParameter('doctrine.dbal.connection_factory.types');
        $modelIds = array_keys($container->findTaggedResourceIds('app.domain.model.id'));

        foreach ($modelIds as $id) {
            if (Id::class === $id) {
                continue;
            }

            $typeDefinition[$id] = ['class' => IdType::class];
        }

        $container->setParameter('doctrine.dbal.connection_factory.types', $typeDefinition);
    }
}
