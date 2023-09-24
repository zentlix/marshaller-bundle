<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests;

use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\Attributes\Group;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[Group('functional')]
final class MarshallerBundleTest extends WebTestCase
{
    #[DoesNotPerformAssertions]
    public function testItDoesNotThrowWhenBootingKernel(): void
    {
        self::bootKernel();
    }

    protected static function createKernel(array $options = []): AppKernel
    {
        return new AppKernel('test', true);
    }
}
