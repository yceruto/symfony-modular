<?php

namespace App;

use App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler\RegisterGenericDbalTypesPass;
use App\Shared\Infrastructure\Symfony\DependencyInjection\Compiler\MergeExtensionConfigurationPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function prepareContainer(ContainerBuilder $container): void
    {
        parent::prepareContainer($container);

        $container->getCompilerPassConfig()->setMergePass(new MergeExtensionConfigurationPass());
    }

    protected function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterGenericDbalTypesPass($container));
    }
}
