<?php

namespace BudDemoPlugin\Plugin;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;
use BudDemoPlugin\Block\Contract\BlockRepositoryInterface;
use BudDemoPlugin\Asset\Contract\ManifestInterface;

/**
 * Register bud-demo-plugin/bud-demo block assets
 *
 * @see Enqueueing Editor Assets <https://git.io/JvPHy>
 * @see Dependency Extraction Webpack Plugin <https://git.io/Jv1ll>
 */
class Registration
{
    /** @var ContainerInterface */
    public $bud;

    /** @var Collection */
    public $collection;

    /** @var BlockRepositoryInterface */
    public $blocks;

    /** @var ManifestInterface */
    public $manifest;

    /**
      * Class constructor.
      *
      * @param ContainerInterface       $bud
      * @param Collection               $collection
      * @param BlockRepositoryInterface $blocks
      * @param ManifestInterface        $manifest
      */
    public function __construct(
        ContainerInterface $bud,
        Collection $collection,
        BlockRepositoryInterface $blocks,
        ManifestInterface $manifest
    ) {
        $this->bud = $bud;
        $this->collection = $collection;
        $this->blocks = $blocks;
        $this->manifest = $manifest;
    }

    /**
      * Class invocation.
      *
      * @throws \WP_Error
      * @return void
      */
    public function __invoke(): void
    {
        $this->load();
        $this->register();
    }

    /**
      * Load blocks and assets.
      *
      * @return void
      */
    protected function load(): void
    {
        $this->bud->get('plugin.blocks')->each(function ($name) {
            $block = $this->bud->make(BlockInterface::class);

            $block->setName($name);
            $block->setAssets($this->manifest->getAssets($block));

            $this->blocks->add($block);
        });
    }

    /**
      * Register blocks and their assets.
      *
      * @return void
      */
    protected function register(): void
    {
        $this->blocks->all()->each(function (BlockInterface $block) {
            $block->getAssets()->each(function (AssetInterface $asset) {
                $asset->register();
            });
        })->each(function (BlockInterface $block) {
            $block->register();
        });
    }
}
