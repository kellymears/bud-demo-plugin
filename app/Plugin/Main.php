<?php

namespace BudDemoPlugin\Plugin;

use Psr\Container\ContainerInterface;

/**
 * Plugin main.
 */
class Main
{
    /**
     * Register plugin assets
     *
     * @param  ContainerInterface $bud
     * @return void
     */
    public function __invoke(ContainerInterface $bud): void
    {
        register_activation_hook(__FILE__, $bud->get('plugin.activate'));
        register_deactivation_hook(__FILE__, $bud->get('plugin.deactivate'));

        add_action('init', $bud->get('asset.registration'));
    }
}
