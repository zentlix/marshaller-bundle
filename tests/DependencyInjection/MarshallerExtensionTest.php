<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Spiral\Attributes\ReaderInterface;
use Spiral\Marshaller\MarshallerInterface;
use Zentlix\MarshallerBundle\DependencyInjection\MarshallerExtension;
use Zentlix\MarshallerBundle\Marshaller;

final class MarshallerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new MarshallerExtension(),
        ];
    }

    public function testItDoesNotRegisterTheMapperFactoryServiceWhenNotConfigured(): void
    {
        $this->load([]);

        $this->assertFalse($this->container->hasParameter('marshaller.mapper_factory.service_id'));
    }

    public function testItRegistersTheMapperFactoryServiceWhenConfigured(): void
    {
        $this->load([
            'mapper_factory' => 'my_mapper_factory',
        ]);

        $this->assertContainerBuilderHasParameter('marshaller.mapper_factory.service_id', 'my_mapper_factory');
    }

    public function testContainerHasAttributeReaderService(): void
    {
        $this->load([]);

        $this->assertContainerBuilderHasService('marshaller.attribute_reader', ReaderInterface::class);
    }

    public function testContainerHasMarshallerService(): void
    {
        $this->load([]);

        $this->assertContainerBuilderHasService('marshaller', Marshaller::class);
        $this->assertContainerBuilderHasAlias(MarshallerInterface::class, Marshaller::class);
    }

    public function testContainerNotHasUuidTypeService(): void
    {
        $this->load([]);

        $this->assertContainerBuilderNotHasService('marshaller.type.symfony_uuid');
    }
}
