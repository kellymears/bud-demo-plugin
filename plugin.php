<?php
/**
 * Plugin Name:  bud-demo-plugin
 * Plugin URI:   https://roots.io/bud
 * Description:  Bud output testing and demonstration
 * Author:       Kelly M. <kelly@roots.io>
 * License:      MIT
 * Text Domain:  bud-demo-plugin
 *
 * @package bud-demo-plugin
 */

namespace BudDemoPlugin;

/**
 * bud-demo-plugin/bud-demo-plugin
 *
 * @note this
 */
(new class {
    /** @var string */
    public $autoload;

    /** @var string */
    public $container;

    /** @var string */
    public $config;

    /** @var Psr\Container\ContainerInterface */
    public $bud;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->dir = __DIR__;
        $this->autoload = realpath("{$this->dir}/vendor/autoload.php");
        $this->bootstrap = realpath("{$this->dir}/bud/lib/bootstrap.php");
    }

    /**
     * Class invocation.
     */
    public function __invoke()
    {
        if (! $this->autoload) {
            add_action('admin_notices', [$this, 'composerError']);

            return;
        }

        /** Require autoloader */
        require_once $this->autoload;

        /** Set dir reference for bootstrap */
        $dir = $this->dir;

        /** Instantiate the Bud container */
        $this->bud = require $this->bootstrap;

        /** Do plugin main */
        $this->bud->make('plugin.init')();
    }

    /**
     * Autoloader not found
     */
    public function composerError(): void
    {
        print '<div class="notice notice-error">
            <p><strong>There\'s a problem with the bud-demo-plugin plugin.</strong></p>
            <p>Please run <code>composer install</code> in <code>' . __DIR__ .'</code></p>
        </div>';
    }
})();
