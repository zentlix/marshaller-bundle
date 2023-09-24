<?php

declare(strict_types=1);

namespace Zentlix\MarshallerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('marshaller');

        /**
         * @var ArrayNodeDefinition $rootNode
         */
        $rootNode = $treeBuilder->getRootNode();

        /*
         * @psalm-suppress UndefinedInterfaceMethod
         * @psalm-suppress PossiblyNullReference
         */
        $rootNode
            ->children()
                ->scalarNode('mapper_factory')
                    ->info('a service definition id implementing Spiral\Marshaller\Mapper\MapperFactoryInterface')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
