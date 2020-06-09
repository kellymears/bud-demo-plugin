<?php

namespace BudDemoPlugin\Plugin;

use Psr\Container\ContainerInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;
use BudDemoPlugin\Asset\Contract\CollectionInterface;

/**
 * Register bud-demo-plugin/bud-demo-plugin block assets
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
      * @param CollectionInterface manifest
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
        /** Register client assets */
        $this->assets->map(function ($asset) {
            $this->registerAsset($asset);
        });

        /** Register blocks */
        $this->assets->ofType('block')->map(
            function ($assets) {
                $this->registerAssetsWithBlock($assets);
            }
        );
    }

    /**
     * Register asset.
     *
     * @param  asset
     * @return void
     */
    public function registerAsset($asset)
    {
        $asset->contains('js')
            ? wp_register_script(...$asset->registration()->toArray())
            : wp_register_style(...$asset->registration()->toArray());

        $asset->put('registered', true);
    }

    /**
     * Register block assets.
     *
     * @param  CollectionInterface assets
     * @return void
     */
    public function registerAssetsWithBlock(CollectionInterface $assets): void
    {
        /** Get block name */
        $name = $assets->pluck('block')->first();

        /** Make a new block object. */
        $block = $this->bud->make(
            BlockInterface::class,
            ['name' => $name]
        );

        /** Set block assets. */
        $assets->each(function ($asset) use ($block) {
            $block->set($asset->get('hook'), $asset->get('name'));
        });

        /** Register block. */
        $block->register();
    }
}