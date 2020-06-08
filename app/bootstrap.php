<?php

/**
 * The bootstrap file creates and returns the plugin container.
 */

namespace BudDemoPlugin;

require __DIR__ . '/../vendor/autoload.php';

use function DI\autowire;
use function DI\create;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

/**
 * Build the container instance
 */
return (new ContainerBuilder)->addDefinitions([
    /** Bindings */
    Plugin\Registration::class => autowire(Plugin\Registration::class),
    Plugin\Activate::class => Plugin\Activate::class,
    Plugin\Deactivate::class => Plugin\Deactivate::class,
    Block\Contract\BlockInterface::class => autowire(Block\Block::class),
    Asset\Contract\CollectionInterface::class => function (ContainerInterface $bud) {
        return Asset\Collection::make()->fromFile($bud, '/dist/manifest.json');
    },

    /** Aliases */
    'plugin.activate' => create(Plugin\Activate::class),
    'plugin.deactivate' => create(Plugin\Deactivate::class),
    'plugin.registration' => autowire(Plugin\Registration::class),
    'block' => autowire(Block\Block::class),
    'asset' => autowire(Asset\Collection::class),

    /** Vendor */
    Illuminate\Support\Collection::class => autowire(Illuminate\Support\Collection::class),

    /** Vendor aliases */
    'collection' => autowire('Illuminate\Support\Collection'),

    /**
     * Reference
     */
    'plugin.namespace' => 'bud-demo-plugin',
    'plugin.url' => plugins_url('', __DIR__),
    'path.wp' => WP_CONTENT_DIR,
    'path.wp.plugins' => plugin_dir_path('', __DIR__),
    'path.wp.uploads' => (object) wp_upload_dir(),
    'path.plugin' => realpath(__DIR__ . '/../'),
    'path.plugin.dist' => realpath(__DIR__ . '/../dist/'),
    'path.plugin.src' => realpath(__DIR__ . '/../src/'),
    'path.plugin.src.blocks' => realpath(__DIR__ . '/../src/blocks'),
    'path.plugin.src.plugins' => realpath(__DIR__ . '/../src/plugins'),
    'path.plugin.storage' => realpath(__DIR__ . '/../storage/'),
    'path.plugin.storage.cache' => realpath(__DIR__ . '/../storage/cache'),
    'path.plugin.activate' => realpath(__DIR__ . '/Plugin/Activate.php'),
    'path.plugin.deactivate' => realpath(__DIR__ . '/Plugin/Deactivate.php'),
])->build();
