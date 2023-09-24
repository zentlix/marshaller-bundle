<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\Uid\Uuid;

final class MarshallerExtension extends ConfigurableExtension
{
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__, 2).'/config'));

        $loader->load('services.php');

        if (!ContainerBuilder::willBeAvailable('symfony/uid', Uuid::class, [])) {
            $container->removeDefinition('marshaller.type.symfony_uuid');
        }

        if (isset($mergedConfig['mapper_factory'])) {
            $container->setParameter('marshaller.mapper_factory.service_id', $mergedConfig['mapper_factory']);
        }
    }
}
