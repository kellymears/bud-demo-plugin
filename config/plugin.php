<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Plugin name
    |--------------------------------------------------------------------------
    |
    | The name of the plugin.
    |
    */

    'name' => 'ACME Co. Plugin',

    /*
    |--------------------------------------------------------------------------
    | Plugin url
    |--------------------------------------------------------------------------
    |
    | The base URL of the plugin.
    |
    */

    'url' => plugins_url('', __DIR__),

    /*
    |--------------------------------------------------------------------------
    | Plugin directories
    |--------------------------------------------------------------------------
    |
    | Important directories for the plugin.
    |
    */

    'directories' => [
        'src' => 'src',
        'dist' => 'dist',
        'config' => 'config',
        'languages' => 'resources/languages',
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugin files
    |--------------------------------------------------------------------------
    |
    | Important files for the plugin.
    |
    */

    'files' => [
        'manifest' => 'dist/manifest.json',
    ],

];
