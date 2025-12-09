<?php

namespace App;

use App\Catalog\Room\Infrastructure\RoomExtension;
use App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler\IdTypePass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new IdTypePass());

        $container->registerExtension(new RoomExtension());
    }
}
