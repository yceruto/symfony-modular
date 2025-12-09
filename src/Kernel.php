<?php

namespace App;

use App\Catalog\Room\Infrastructure\RoomExtension;
use App\Shared\Infrastructure\Persistence\Doctrine\DBAL\Type\IdType;
use App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler\IdTypePass;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Types\Exception\TypeAlreadyRegistered;
use Doctrine\DBAL\Types\Exception\TypesAlreadyExists;
use Doctrine\DBAL\Types\Type;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function boot(): void
    {
        parent::boot();

        $this->registerDoctrineTypes();
    }

    private function registerDoctrineTypes(): void
    {
        /** @var array<string, string> $types */
        $types = $this->container->getParameter('app.persistence.doctrine.dbal.types');

        foreach ($types as $name => $type) {
            try {
                Type::addType($name, $type);
            } catch (Exception) {
                continue;
            }
        }
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new IdTypePass());

        $container->registerExtension(new RoomExtension());
    }
}
