<?php
/**
 * Plugin Name:  Bud Demo
 * Plugin URI:   https://roots.io/bud
 * Description:  A simple plugin demonstrating Bud&amp;#x27;s output
 * Author:       Kelly Mears <kelly@roots.io>
 * License:      MIT
 * Text Domain:  bud-demo-plugin
 *
 * @package bud-demo-plugin
 */

namespace BudDemoPlugin;

/**
 * Bud Demo
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
            <p><strong>There\'s a problem with the Bud Demo plugin.</strong></p>
            <p>Please run <code>composer install</code> in <code>' . __DIR__ .'</code></p>
        </div>';
    }
})();
