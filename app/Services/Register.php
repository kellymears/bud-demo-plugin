<?php

namespace AcmeCo\Services;

use Roots\Bud\Services\ServiceProvider;
use Roots\Bud\Container\Contracts\ContainerInterface;

/**
 * Register client assets
 */
class Register extends ServiceProvider
{
    /** @var ContainerInterface */
    public $bud;

    /**
      * Boot plugin service.
      *
      * @return void
      */
    public function boot(): void
    {
        $this->registerAssets();
    }

    /**
     * Register assets on init.
     *
     * @return void
     */
    public function registerAssets(): void
    {
        $this->bud['collection']::make(['editor','public'])->each(
            function ($asset) {
                $this->bud['manifest']->has("{$asset}.js")
                    && wp_register_script(
                        "{$asset}/script",
                        $this->bud['manifest']->asset("{$asset}.js")->url(),
                        $this->bud['manifest']->asset("{$asset}.json")->dependencies(),
                        null,
                    );

                $this->bud['manifest']->has("{$asset}.css")
                    && wp_register_style(
                        "{$asset}/style",
                        $this->bud['manifest']->asset("{$asset}.css")->url(),
                        [],
                        null,
                    );
            }
        );
    }

    /**
     * On admin_init.
     *
     * @return void
     */
    public function adminInit(): void
    {
        wp_enqueue_script('editor/script');
        wp_enqueue_style('editor/style');
    }

    /**
     * On wp_enqueue_scripts.
     *
     * @return void
     */
    public function enqueueScripts(): void
    {
        wp_enqueue_script('public/script');
        wp_enqueue_style('public/style');
    }
}
