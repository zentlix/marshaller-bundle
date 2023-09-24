<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Tests;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Zentlix\MarshallerBundle\MarshallerBundle;

final class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [
            new MarshallerBundle(),
        ];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
    }
}
