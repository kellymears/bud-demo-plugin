<?php
/**
 * Plugin Name:  acme-project
 * Plugin URI:   https://acme.co
 * Description:  Anvil drop-shipping application
 * Author:       Wiley C. <wiley@gmail.com>
 * License:      MIT
 * Text Domain:  acme-co
 *
 * @package acme-co
 */

namespace AcmeCo;

use Roots\Bud\Bud;

/**
 * acme-co/acme-project
 */
(new class {
    /** @var string */
    public $autoload;

    /** @var Psr\Container\ContainerInterface */
    public $bud;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->dir = __DIR__;

        if (! $this->autoload = realpath("{$this->dir}/vendor/autoload.php")) {
            return add_action('admin_notices', [$this, 'composerError']);
        }

        require_once $this->autoload;
    }

    /**
     * Class invocation.
     */
    public function __invoke()
    {
        $this->bud = new Bud($this->dir);
        add_action('init', $this->bud);
    }

    /**
     * Autoloader not found
     */
    public function composerError(): void
    {
        print '<div class="notice notice-error">
            <p><strong>There&apos;s a problem with the bud-demo-plugin plugin.</strong></p>
            <p>Please run <code>composer install</code> in <code>' . $this->dir .'</code></p>
        </div>';
    }
})();
