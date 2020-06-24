<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Autoloaded services
    |--------------------------------------------------------------------------
    |
    | These services are automatically instantiated and made available throughout
    | your plugin.
    |
    */

    'autoload' => [
        'plugin.register' => AcmeCo\Services\Register::class,
        'plugin.main' => AcmeCo\Services\Main::class,
        'collection' => Roots\Bud\Collection\Collection::class,
        'manifest' => Roots\Bud\Manifest\Manifest::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin services
    |--------------------------------------------------------------------------
    |
    | These services are made available to your plugin but are not instantiated
    | until they are requested.
    |
    */

    'services' => [
        'asset' => Roots\Bud\Asset\Asset::class,
        'plugin.activate' => join('/', [plugin_dir_path(__DIR__), 'app/Plugin/Activate.php']),
        'plugin.deactivate' => join('/', [plugin_dir_path(__DIR__), 'app/Plugin/Deactivate.php']),
    ],

    /*
    |--------------------------------------------------------------------------
    | Service hooks
    |--------------------------------------------------------------------------
    |
    | Map WordPress hooks to service provider methods.
    |
    */

    'service_hooks' => [
        'admin_init' => 'adminInit',
        'enqueue_block_assets', 'enqueueBlockAssets',
        'enqueue_block_editor_assets' => 'enqueueBlockEditorAssets',
        'wp_enqueue_scripts' => 'enqueueScripts',
    ],

];
