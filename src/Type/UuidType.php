<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Type;

use Spiral\Marshaller\MarshallingRule;
use Spiral\Marshaller\Support\Inheritance;
use Spiral\Marshaller\Type\DetectableTypeInterface;
use Spiral\Marshaller\Type\NullableType;
use Spiral\Marshaller\Type\RuleFactoryInterface;
use Spiral\Marshaller\Type\Type;
use Symfony\Component\Uid\Uuid;

final class UuidType extends Type implements DetectableTypeInterface, RuleFactoryInterface
{
    public static function match(\ReflectionNamedType $type): bool
    {
        return !$type->isBuiltin() && Inheritance::extends($type->getName(), Uuid::class);
    }

    public static function makeRule(\ReflectionProperty $property): ?MarshallingRule
    {
        $type = $property->getType();

        if (!$type instanceof \ReflectionNamedType || !self::match($type)) {
            return null;
        }

        return $type->allowsNull()
            ? new MarshallingRule(
                $property->getName(),
                NullableType::class,
                new MarshallingRule(type: self::class, of: $type->getName()),
            )
            : new MarshallingRule($property->getName(), self::class, $type->getName());
    }

    /**
     * @psalm-assert string $value
     */
    public function parse(mixed $value, mixed $current): Uuid
    {
        return Uuid::fromString($value);
    }

    /**
     * @psalm-assert Uuid $value
     */
    public function serialize(mixed $value): ?string
    {
        return $value instanceof Uuid ? $value->toRfc4122() : null;
    }
}
