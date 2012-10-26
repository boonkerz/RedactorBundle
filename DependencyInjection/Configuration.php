<?php

namespace TP\RedactorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tp_redactor');
        $rootNode
            ->children()
                ->scalarNode('default_config_set')
                    ->defaultValue('default')
                    ->info('The default config set. Must be defined in "config_sets"')
                ->end()
                ->arrayNode('config_sets')
                    ->defaultValue(array('default' => array('shortcuts' => false)))
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->prototype('variable')->end()
                    ->end()
                    ->info('Redactor config sets given to JavaScript')
                ->end()
                ->variableNode('transformers')
                    ->defaultValue(array('strip_js', 'strip_css', 'strip_comments'))
                    ->info("Default data transformers for the submitted html.")
                ->end()
            ->end();

        return $treeBuilder;
    }
}
