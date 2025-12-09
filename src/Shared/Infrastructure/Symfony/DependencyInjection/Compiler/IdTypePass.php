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
        $modelIds = array_keys($container->findTaggedResourceIds('app.model.id'));

        $types = [];
        foreach ($modelIds as $id) {
            if (Id::class === $id) {
                continue;
            }

            $types[$id] = IdType::class;
        }

        $container->setParameter('app.persistence.doctrine.dbal.types', $types);
    }
}
