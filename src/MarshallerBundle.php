<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Zentlix\MarshallerBundle\DependencyInjection\RegisterMapperFactoryCompilerPass;

final class MarshallerBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterMapperFactoryCompilerPass());
    }

    public function getContainerExtension(): ExtensionInterface
    {
        return new DependencyInjection\MarshallerExtension();
    }
}
