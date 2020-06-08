<?php
/**
 * Plugin Name:  bud-demo-plugin
 * Plugin URI:   https://roots.io/bud
 * Description:  Bud output reference.
 * Author:       Kelly M. <kelly@roots.io>
 * License:      MIT
 * Text Domain:  bud-demo-plugin
 *
 * @package bud-demo-plugin
 */

namespace BudDemoPlugin;

/**
 * bud-demo-plugin
 */
(new class {
    /** @var string */
    public $autoload;

    /** @var string */
    public $container;

    /** @var Psr\Container\ContainerInterface */
    public $bud;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->autoload = realpath(__DIR__ . '/vendor/autoload.php');
        $this->bootstrap = realpath(__DIR__ . '/app/bootstrap.php');
    }

    /**
     * Instantiate the plugin.
     */
    public function __invoke()
    {
        if (! $this->autoload) {
            add_action('admin_notices', [$this, 'composerError']);
            return;
        }

        /**
         * Instantiate the plugin container.
         */
        $this->bud = require $this->bootstrap;

        /**
         * Register script and style assets.
         */
        add_action('init', $this->bud->get('plugin.registration'));

        /**
         * Handle plugin lifecycle.
         */
        register_activation_hook(__FILE__, $this->bud->get('plugin.activate'));
        register_deactivation_hook(__FILE__, $this->bud->get('plugin.deactivate'));
    }

    /**
     * Alert if autoloader can't be found.
     *
     * @return void
     */
    public function composerError(): void
    {
        print '<div class="notice notice-error">
            <p><strong>There\'s a problem with the bud-demo-plugin plugin.</strong></p>
            <p>Please run <code>composer install</code> in <code>' . __DIR__ .'</code></p>
        </div>';
    }
})();
