<?php

namespace App\Shared\Infrastructure;

use App\Shared\Domain\Model\Id;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\AbstractExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

abstract class AppExtension extends AbstractExtension
{
    protected private(set) string $path {
        get {
            return $this->path ??= \dirname(new \ReflectionObject($this)->getFileName(), 2);
        }
    }

    protected private(set) string $namespace {
        get {
            return $this->namespace ??= preg_replace('/\\\\Infrastructure\\\\[^\\\\]+$/', '', $this::class);
        }
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $this->configureDoctrineMapping($container);

        if (is_dir($this->path.'/Infrastructure/Resources/config/packages')) {
            $container->import($this->path.'/Infrastructure/Resources/config/packages/*.yaml');
        }
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->registerForAutoconfiguration(Id::class)
            ->addResourceTag('app.model.id');

        $builder->registerForAutoconfiguration(self::class)
            ->addTag('container.excluded', ['source' => 'because it\'s a container extension']);

        if (\is_dir($this->path.'/Infrastructure/Resources/config')) {
            $container->import($this->path.'/Infrastructure/Resources/config/{services.yaml}');
        }
    }

    protected function configureDoctrineMapping(ContainerConfigurator $container): void
    {
        $container->extension('doctrine', [
            'orm' => [
                'mappings' => [
                    $this->namespace => [
                        'type' => 'attribute',
                        'is_bundle' => false,
                        'dir' => $this->path.'/Domain/Model',
                        'prefix' => $this->namespace.'\\Domain\\Model',
                        'alias' => $this->namespace.'\\Domain\\Model',
                    ],
                ],
            ],
        ], true);
    }
}
