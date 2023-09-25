<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\Type;

final class Type
{
    private string $fqcn;

    /**
     * @param class-string $class
     */
    public function __construct(string $class)
    {
        $this->fqcn = $class;
    }

    public function getType(): string
    {
        return $this->fqcn;
    }
}
