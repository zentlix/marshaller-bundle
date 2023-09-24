<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\DependencyInjection;

use Spiral\Marshaller\Mapper\MapperFactoryInterface;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterMapperFactoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $serviceParameter = 'marshaller.mapper_factory.service_id';
        if (!$container->hasParameter($serviceParameter)) {
            $container->setAlias('marshaller.mapper_factory', 'marshaller.attribute_mapper_factory');

            return;
        }

        $serviceId = $container->getParameter($serviceParameter);
        if (false === \is_string($serviceId)) {
            return;
        }

        $this->assertDefinitionImplementsInterface($container, $serviceId, MapperFactoryInterface::class);

        $container->setAlias('marshaller.mapper_factory', new Alias($serviceId, true));
    }

    /**
     * @param class-string $interface
     */
    private function assertDefinitionImplementsInterface(
        ContainerBuilder $container,
        string $definitionId,
        string $interface
    ): void {
        $this->assertContainerHasDefinition($container, $definitionId);

        $definition = $container->getDefinition($definitionId);
        $definitionClass = $container->getParameterBag()->resolveValue($definition->getClass());

        $reflectionClass = new \ReflectionClass($definitionClass);

        if (!$reflectionClass->implementsInterface($interface)) {
            throw new \InvalidArgumentException(
                sprintf('Service `%s` must implement interface `%s`.', $definitionClass, $interface)
            );
        }
    }

    private function assertContainerHasDefinition(ContainerBuilder $container, string $definitionId): void
    {
        if (!$container->hasDefinition($definitionId)) {
            throw new \InvalidArgumentException(
                sprintf('Service id `%s` could not be found in container.', $definitionId)
            );
        }
    }
}
