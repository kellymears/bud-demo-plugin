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

$builder = new ContainerBuilder;

/**
 * Build the container instance
 */
$builder->addDefinitions([
    /**
     * Plugin bindings
     */
    Plugin\Registration::class => autowire(Plugin\Registration::class),
    Plugin\Activate::class => Plugin\Activate::class,
    Plugin\Deactivate::class => Plugin\Deactivate::class,
    Asset\Contract\AssetInterface::class => autowire(Asset\Asset::class),
    Block\Contract\BlockInterface::class => autowire(Block\Block::class),
    Block\Contract\BlockRepositoryInterface::class => autowire(Block\BlockRepository::class),
    Asset\Contract\ManifestInterface::class => autowire(Asset\Manifest::class),

    /**
     * Plugin aliases
     */
    'plugin.activate' => create(Plugin\Activate::class),
    'plugin.deactivate' => create(Plugin\Deactivate::class),
    'plugin.registration' => autowire(Plugin\Registration::class),
    'asset' => autowire(Asset\Asset::class),
    'block' => autowire(Block\Block::class),
    'manifest' => autowire(Asset\Manifest::class),
    'blocks' => autowire(Block\BlockRepository::class),

    /**
     * Vendor bindings
     */
    Illuminate\Support\Collection::class => autowire(Illuminate\Support\Collection::class),

    /**
     * Vendor aliases
     */
    'collection' => autowire('Illuminate\Support\Collection'),

    /**
     * Config
     */
    'plugin.namespace' => 'bud-demo-plugin',
    'plugin.manifest' => function (ContainerInterface $bud) {
        if (! $manifestPath = realpath(__DIR__ . '/../dist/assets.json')) {
            return;
        }

        return $bud->get('collection')::make(
            json_decode(file_get_contents($manifestPath))
        );
    },
    'plugin.blocks' => function(ContainerInterface $bud) {
        return $bud->get('collection')::make(
            glob($bud->get('path.plugin.src.blocks') . '/*', GLOB_ONLYDIR)
        )->map(function ($path) {
            return str_replace($this->bud->get('path.plugin.src.blocks') . '/', '', $path);
        });
    },
    'plugin.url' => plugins_url('', __DIR__),
    'path.wp' => WP_CONTENT_DIR,
    'path.wp.plugins' => plugin_dir_path('', __DIR__),
    'path.wp.uploads' => (object) wp_upload_dir(),
    'path.plugin' => realpath(__DIR__ . '/../'),
    'path.plugin.dist' => realpath(__DIR__ . '/../dist/'),
    'path.plugin.src' => realpath(__DIR__ . '/../src/'),
    'path.plugin.src.blocks' => realpath(__DIR__ . '/../src/blocks'),
    'path.plugin.storage' => realpath(__DIR__ . '/../storage/'),
    'path.plugin.storage.cache' => realpath(__DIR__ . '/../storage/cache'),
    'path.plugin.activate' => realpath(__DIR__ . '/Plugin/Activate.php'),
    'path.plugin.deactivate' => realpath(__DIR__ . '/Plugin/Deactivate.php'),
]);

return $builder->build();
