<?php

namespace BudDemoPlugin\Asset;

use Psr\Container\ContainerInterface;
use Roots\Bud\Block\Contract\BlockInterface;
use Roots\Bud\Asset\Contract\CollectionInterface;

/**
 * Register bud-demo-plugin/bud-demo-plugin block and plugin assets
 *
 * @see Enqueueing Editor Assets <https://git.io/JvPHy>
 * @see Dependency Extraction Webpack Plugin <https://git.io/Jv1ll>
 */
class Registration
{
    /** @var ContainerInterface */
    public $bud;

    /** @var CollectionInterface */
    public $assets;

    /**
      * Class constructor.
      *
      * @param ContainerInterface  bud
      * @param CollectionInterface assets
      */
    public function __construct(
        ContainerInterface $bud,
        CollectionInterface $assets
    ) {
        $this->bud = $bud;
        $this->assets = $assets;
    }

    /**
      * Class invocation.
      *
      * @return void
      */
    public function __invoke(): void
    {
        $this->assets->map(function ($asset) {
            $this->registerAsset($asset);
        });

        $this->assets->ofType('block')->map(function ($assets) {
            $this->registerBlockWithAssets($assets);
        });
    }

    /**
     * Register asset.
     *
     * @param  asset
     * @return void
     */
    public function registerAsset($asset): void
    {
        $asset->contains('js')
            ? wp_register_script(...$asset->registration()->toArray())
            : wp_register_style(...$asset->registration()->toArray());

        $asset->put('registered', true);
    }

    /**
     * Register block with its associated assets.
     *
     * @param  CollectionInterface assets
     * @return void
     */
    public function registerBlockWithAssets(CollectionInterface $assets): void
    {
        /** Get block name */
        $name = $assets->pluck('block')->first();

        /** Make a new block object. */
        $block = $this->bud->make(BlockInterface::class, ['name' => $name]);

        /** Set block assets. */
        $assets->each(function ($asset) use ($block) {
            $block->set($asset->get('hook'), $asset->get('name'));
        });

        /** Register block. */
        $block->register();
    }
}