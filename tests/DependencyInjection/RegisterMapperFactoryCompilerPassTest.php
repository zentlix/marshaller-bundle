<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Spiral\Marshaller\Mapper\MapperFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Zentlix\MarshallerBundle\DependencyInjection\RegisterMapperFactoryCompilerPass;

final class RegisterMapperFactoryCompilerPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterMapperFactoryCompilerPass());
    }

    public function testItSetsTheMapperFactoryAliasToAttributeByDefault(): void
    {
        $this->compile();

        $this->assertContainerBuilderHasAlias('marshaller.mapper_factory', 'marshaller.attribute_mapper_factory');
    }

    public function testItSetsThePublicMapperFactoryAlias(): void
    {
        $this->container->setParameter('marshaller.mapper_factory.service_id', 'my_mapper_factory');

        $this->setDefinition('my_mapper_factory', new Definition(MapperFactoryInterface::class));

        $this->compile();

        $this->assertContainerBuilderHasAlias('marshaller.mapper_factory', 'my_mapper_factory');
        $this->assertTrue($this->container->getAlias('marshaller.mapper_factory')->isPublic());
    }

    public function testItThrowsWhenConfiguredMapperFactoryHasNoDefinition(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Service id `my_mapper_factory` could not be found in container');
        $this->container->setParameter('marshaller.mapper_factory.service_id', 'my_mapper_factory');

        $this->compile();
    }

    public function testItThrowsWhenConfiguredMapperFactoryDoesNotImplementMapperFactoryInterface(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf(
            'Service `%s` must implement interface `%s`.',
            \stdClass::class,
            MapperFactoryInterface::class
        ));
        $this->container->setParameter('marshaller.mapper_factory.service_id', 'my_mapper_factory');

        $this->setDefinition('my_mapper_factory', new Definition(\stdClass::class));

        $this->compile();
    }
}
