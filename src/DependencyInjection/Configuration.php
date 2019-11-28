<?php

declare(strict_types=1);

namespace Free2er\Json\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Конфигурация модуля
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Возвращает строителя конфигурации
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('json_negotiator');
        $builder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('content_types')
                    ->scalarPrototype()->cannotBeEmpty()->end()
                    ->defaultValue([
                        'json',
                        'jsonld',
                    ])
                ->end()
                ->arrayNode('methods')
                    ->scalarPrototype()->cannotBeEmpty()->end()
                    ->defaultValue([
                        'POST',
                        'PATCH',
                        'PUT',
                    ])
                ->end()
            ->end();

        return $builder;
    }
}
