<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Spiral\Attributes\AttributeReader;
use Spiral\Marshaller\Mapper\AttributeMapperFactory;
use Spiral\Marshaller\Marshaller;
use Spiral\Marshaller\MarshallerInterface;
use Spiral\Marshaller\MarshallingRule;
use Spiral\Marshaller\Type\NullableType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;
use Zentlix\MarshallerBundle\Type\UuidType;

final class UuidTypeTest extends TestCase
{
    private MarshallerInterface $marshaller;

    protected function setUp(): void
    {
        parent::setUp();

        $this->marshaller = new Marshaller(
            new AttributeMapperFactory(new AttributeReader()),
            [UuidType::class],
        );
    }

    #[DataProvider('matchDataProvider')]
    public function testMatch(string $property, bool $expected): void
    {
        $this->assertSame(
            UuidType::match((new \ReflectionProperty(PropertyType::class, $property))->getType()),
            $expected
        );
    }

    #[DataProvider('makeRuleDataProvider')]
    public function testMakeRule(string $property, mixed $expected): void
    {
        $this->assertEquals(
            UuidType::makeRule(new \ReflectionProperty(PropertyType::class, $property)),
            $expected
        );
    }

    public function testParse(): void
    {
        $type = new UuidType($this->marshaller);

        $this->assertEquals(
            Uuid::fromString('d1fb065d-f118-477d-a62a-ef93dc7ee03f'),
            $type->parse('d1fb065d-f118-477d-a62a-ef93dc7ee03f', null)
        );
    }

    public function testSerialize(): void
    {
        $type = new UuidType($this->marshaller);

        $this->assertEquals(
            'd1fb065d-f118-477d-a62a-ef93dc7ee03f',
            $type->serialize(Uuid::fromString('d1fb065d-f118-477d-a62a-ef93dc7ee03f'))
        );
    }

    public static function matchDataProvider(): \Traversable
    {
        yield ['string', false];
        yield ['int', false];
        yield ['float', false];
        yield ['bool', false];
        yield ['array', false];
        yield ['nullableString', false];
        yield ['nullableInt', false];
        yield ['nullableFloat', false];
        yield ['nullableBool', false];
        yield ['nullableArray', false];
        yield ['uuid', true];
        yield ['nullableUuid', true];
        yield ['uuidV4', true];
        yield ['nullableUuidV4', true];
    }

    public static function makeRuleDataProvider(): \Traversable
    {
        yield ['string', null];
        yield ['int', null];
        yield ['float', null];
        yield ['bool', null];
        yield ['array', null];
        yield ['nullableString', null];
        yield ['nullableInt', null];
        yield ['nullableFloat', null];
        yield ['nullableBool', null];
        yield ['nullableArray', null];
        yield [
            'uuid',
            new MarshallingRule('uuid', UuidType::class, Uuid::class)
        ];
        yield [
            'nullableUuid',
            new MarshallingRule(
                'nullableUuid',
                NullableType::class,
                new MarshallingRule(type: UuidType::class, of: Uuid::class),
            )
        ];
        yield [
            'uuidV4',
            new MarshallingRule('uuidV4', UuidType::class, UuidV4::class)
        ];
        yield [
            'nullableUuidV4',
            new MarshallingRule(
                'nullableUuidV4',
                NullableType::class,
                new MarshallingRule(type: UuidType::class, of: UuidV4::class),
            )
        ];
    }
}
