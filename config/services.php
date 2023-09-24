<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Spiral\Attributes\Factory;
use Spiral\Attributes\ReaderInterface;
use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\Marshaller;
use Spiral\Marshaller\MarshallerInterface;
use Zentlix\MarshallerBundle\Type\UuidType;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->services()
        ->set('marshaller.attribute_reader', ReaderInterface::class)
            ->factory([Factory::class, 'create'])

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

        ->set('marshaller.type.symfony_uuid', UuidType::class)
            ->args([
                service('marshaller'),
            ])
            ->tag('marshaller.type')
    ;
};
