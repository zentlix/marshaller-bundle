<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Spiral\Attributes\Factory;
use Spiral\Attributes\ReaderInterface;
use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\MarshallerInterface;
use Zentlix\MarshallerBundle\Marshaller;
use Zentlix\MarshallerBundle\Type\Type;
use Zentlix\MarshallerBundle\Type\UuidType;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set('marshaller.attribute_reader_factory', Factory::class)

        ->set('marshaller.attribute_reader', ReaderInterface::class)
            ->factory([service('marshaller.attribute_reader_factory'), 'create'])

        ->set('marshaller.attribute_mapper_factory', AttributeMapperFactory::class)
            ->args([
                service('marshaller.attribute_reader'),
            ])

        ->set('marshaller', Marshaller::class)
            ->args([
                service('marshaller.mapper_factory'),
                tagged_iterator('marshaller.type'),
            ])

        ->alias(MarshallerInterface::class, Marshaller::class)

        ->set('marshaller.type.symfony_uuid', Type::class)
            ->args([
                UuidType::class,
            ])
            ->tag('marshaller.type')
    ;
};
