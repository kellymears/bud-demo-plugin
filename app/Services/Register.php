<?php

namespace AcmeCo\Services;

use Roots\Bud\Services\ServiceProvider;
use Roots\Bud\Container\Contracts\ContainerInterface;

/**
 * Register client assets.
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
        $this->registerEntry('editor');
        $this->registerEntry('public');
    }

    /**
     * Register entrypoint
     *
     * @return void
     */
    public function registerEntry($asset): void
    {
        /**
         * Inline manifest.
         */
        $runtime = $this->bud['manifest']->has("runtime/{$asset}.js")
            ? $this->bud['manifest']->asset("runtime/{$asset}.js")->url()
            : null;

        /**
         * Inline manifest depends on
         */
        $runtimeDependencies = $this->bud['manifest']->has("runtime/{$asset}.json")
            ? $this->bud['manifest']->asset("runtime/{$asset}.json")->json()->dependencies
            : [];

        /**
         * If there is an inline manifest, the entrypoint relies on it in turn.
         */
        $scriptDependencies = $runtime ? ["{$asset}/script/runtime"] : [];

        /**
         * The entrypoint script.
         */
        $script = $this->bud['manifest']->has("{$asset}.js")
            ? $this->bud['manifest']->asset("{$asset}.js")->url()
            : null;

        /**
         * The entrypoint stylesheet.
         */
        $style = $this->bud['manifest']->has("{$asset}.css")
            ? $this->bud['manifest']->asset("{$asset}.css")->url()
            : null;

        /**
         * Register entrypoint runtime.
         */
        if ($runtime) {
            wp_register_script("{$asset}/script/runtime", $runtime, $runtimeDependencies, null);
        }

        /**
         * Register entrypoint script.
         */
        if ($script) {
            wp_register_script("{$asset}/script", $script, $scriptDependencies, null);
        }

        /**
         * Register entrypoint stylesheet.
         */
        if ($style) {
            wp_register_style("{$asset}/style", $style, [], null);
        }
    }

    /**
     * On admin_init.
     *
     * @return void
     */
    public function adminInit(): void
    {
        wp_enqueue_script('editor/script/runtime');
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
        wp_enqueue_script('public/script/runtime');
        wp_enqueue_script('public/script');
        wp_enqueue_style('public/style');
    }
}
