<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Zentlix\MarshallerBundle\DependencyInjection\Configuration;

final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    public function testItAllowsTheMapperFactoryToNotBeConfigured(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [],
            ],
            [],
            'mapper_factory'
        );
    }

    public function testConfigureMapperFactory(): void
    {
        $this->assertProcessedConfigurationEquals(
            [
                [
                    'mapper_factory' => 'my_mapper_factory',
                ],
            ],
            [
                'mapper_factory' => 'my_mapper_factory',
            ],
            'mapper_factory'
        );
    }
}
