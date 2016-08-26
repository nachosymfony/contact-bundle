<?php

namespace nacholibre\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nacholibre_contact');

        $rootNode
            ->children()
                ->scalarNode('config_entity')
                    //->isRequired()
                    //->cannotBeEmpty()
                ->end()
                ->arrayNode('to_emails')
                    //->isRequired()
                    //->cannotBeEmpty()
                    ->prototype('scalar')
                    ->end()
                ->end()
                ->scalarNode('site_name')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        //$rootNode->arrayNode('send_to_emails')->end();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
