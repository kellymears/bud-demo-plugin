<?php

return [
    /**
     * Plugin namespace
     */
    'namespace' => 'BudDemoPlugin',

    /**
     * Plugin base URL
     */
    'url' => plugins_url('', __DIR__),

    /**
     * Plugin filesystem
     */
    'filesystem' => [
        'base' => plugin_dir_path(__DIR__),
        'dist' => 'dist',
        'src' => 'src',
        'blocks' => 'src/blocks',
        'plugins' => 'src/plugins',
        'storage' => 'storage',
        'cache' => 'storage/cache',
    ],
];
