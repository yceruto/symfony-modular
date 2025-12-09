<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Model\Id;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

abstract class SharedExtension extends AbstractExtension
{
    protected private(set) string $path {
        get {
            return $this->path ??= \dirname(new \ReflectionObject($this)->getFileName(), 2);
        }
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if (\is_dir($this->path.'/Infrastructure/Resources/config/packages')) {
            $container->import($this->path.'/Infrastructure/Resources/config/packages/*.yaml');
        }
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->registerForAutoconfiguration(Id::class)
            ->addResourceTag('app.model.id');

        if (\is_dir($this->path.'/Infrastructure/Resources/config')) {
            $container->import($this->path.'/Infrastructure/Resources/config/{services.yaml}');
        }
    }
}
