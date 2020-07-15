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
        $this->registerEntry('vendor');
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
        $entry = $this->maybeAsset($asset);

        if ($entry->runtime) {
            wp_register_script(
                "acme-co/{$asset}/script/runtime",
                $entry->runtime,
                $entry->asset,
                null
            );
        }

        if ($entry->script) {
            wp_register_script(
                "acme-co/{$asset}/script",
                $entry->script,
                ["acme-co/{$asset}/script/runtime"],
                null
            );
        }

        if ($entry->style) {
            wp_register_style(
                "acme-co/{$asset}/style",
                $entry->style,
                [],
                null
            );
        }
    }

    /**
     * On admin_init.
     *
     * @return void
     */
    public function adminInit(): void
    {
        wp_enqueue_script('acme-co/vendor/script');
        wp_enqueue_script('acme-co/editor/script/runtime');
        wp_enqueue_script('acme-co/editor/script');
        wp_enqueue_style('acme-co/editor/style');
    }

    /**
     * On wp_enqueue_scripts.
     *
     * @return void
     */
    public function enqueueScripts(): void
    {
        wp_enqueue_script('acme-co/vendor/script');
        wp_enqueue_script('acme-co/public/script/runtime');
        wp_enqueue_script('acme-co/public/script');
        wp_enqueue_style('acme-co/public/style');
    }

    /**
     * Maybe return asset path, maybe null
     *
     * @param string
     * @return {string|null}
     */
     protected function maybeAsset($asset)
     {
        return (object) [
            'runtime' => $this->bud['manifest']->has("runtime/{$asset}.js")
                ? $this->bud['manifest']->asset("runtime/{$asset}.js")->url()
                : null,

            'script' => $this->bud['manifest']->has("{$asset}.js")
                ? $this->bud['manifest']->asset("{$asset}.js")->url()
                : null,

            'style' => $this->bud['manifest']->has("{$asset}.css")
                ? $this->bud['manifest']->asset("{$asset}.css")->url()
                : null,

            'asset' => $this->bud['manifest']->has("runtime/{$asset}.json")
                ? $this->bud['manifest']->asset("runtime/{$asset}.json")->json()->dependencies
                : null,
        ];
     }
}
