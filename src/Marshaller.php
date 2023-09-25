<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle;

use Spiral\Marshaller\Mapper\MapperFactoryInterface;
use Spiral\Marshaller\Marshaller as SpiralMarshaller;
use Zentlix\MarshallerBundle\Type\Type;

class Marshaller extends SpiralMarshaller
{
    /**
     * @param iterable<Type> $types
     */
    public function __construct(MapperFactoryInterface $mapper, iterable $types)
    {
        $matchers = [];
        foreach ($types as $type) {
            if (!$type instanceof Type) {
                throw new \InvalidArgumentException(sprintf('Expected instance of `%s`, got `%s`.', Type::class, \is_object($type) ? $type::class : \gettype($type)));
            }

            $matchers[] = $type->getType();
        }

        parent::__construct($mapper, $matchers);
    }
}
