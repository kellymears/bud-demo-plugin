<?php

namespace AcmeCo\Services;

use Roots\Bud\Container\ContainerInterface;
use Roots\Bud\Services\ServiceProvider;

/**
 * Plugin service provider.
 */
class Main extends ServiceProvider
{
    /**
     * Boot plugin service.
     *
     * @param  ContainerInterface $bud
     * @return void
     */
    public function boot(): void
    {
        register_activation_hook(__FILE__, $this->bud['plugin.activate']);
        register_deactivation_hook(__FILE__, $this->bud['plugin.deactivate']);

        load_plugin_textdomain('acme-co', false, $this->bud['directories']->languages);
     }
}

