<?php

namespace SimpleBus\SymfonyBridge\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class EventBusConfiguration implements ConfigurationInterface
{
    private $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root($this->alias);
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->enumNode('event_name_resolver_strategy')
                    ->values(['class_based', 'named_message'])
                    ->defaultValue('class_based')
                ->end()
                ->arrayNode('logging')
                    ->addDefaultsIfNotSet()
                    ->canBeEnabled()
                    ->children()
                        ->scalarNode('channel')
                            ->defaultValue('event_bus')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
