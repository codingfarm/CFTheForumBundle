<?php

namespace CF\TheForumBundle\DependencyInjection;

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

        $rootNode = $treeBuilder->root('cf_the_forum');
        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(array('orm'))
                        ->thenInvalid("The database driver must be defined")
                    ->end()
                ->end()
                ->arrayNode('image')->isRequired()
                    ->children()
                        ->scalarNode('upload_dir')->isRequired()->end()
                        ->scalarNode('max_height')->isRequired()->end()
                        ->scalarNode('max_width')->isRequired()->end()
                    ->end()
                ->end()
                ->arrayNode('video')->isRequired()
                    ->children()
                        ->scalarNode('width')->isRequired()->end()
                        ->scalarNode('height')->isRequired()->end()
                    ->end()
                ->end()
                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('post')->isRequired()->end()
                                ->scalarNode('topic')->isRequired()->end()
                                ->scalarNode('category')->isRequired()->end()
                            ->end()
                        ->end()
                        ->arrayNode('bridge')->isRequired()
                            ->children()
                                ->scalarNode('user_meta')->isRequired()->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()

                ->arrayNode('templates')
                    ->children()
                        ->scalarNode('layout')->end()
                    ->end()
                ->end()
                ->arrayNode('video_url_services')->isRequired()->prototype('scalar')->end()->end()
                ->arrayNode('bbcode_filters')->isRequired()->prototype('scalar')->end()->end()
            ->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
