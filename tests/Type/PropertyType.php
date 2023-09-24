<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests\Type;

use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

final class PropertyType
{
    public string $string;
    public int $int;
    public float $float;
    public bool $bool;
    public array $array;
    public ?string $nullableString;
    public ?int $nullableInt;
    public ?float $nullableFloat;
    public ?bool $nullableBool;
    public ?array $nullableArray;
    public Uuid $uuid;
    public ?Uuid $nullableUuid;
    public UuidV4 $uuidV4;
    public ?UuidV4 $nullableUuidV4;
}
