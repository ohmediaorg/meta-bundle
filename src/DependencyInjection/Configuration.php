<?php

namespace OHMedia\MetaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('oh_media_meta');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('title')
                    ->isRequired()
                ->end()
                ->scalarNode('description')
                    ->isRequired()
                ->end()
                ->scalarNode('image')
                    ->isRequired()
                ->end()
                ->scalarNode('separator')
                    ->defaultValue('|')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
