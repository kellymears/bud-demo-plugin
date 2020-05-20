<?php

namespace BudDemoPlugin\Block\Base;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;

/**
 * Block class.
 */
abstract class AbstractBlock extends \WP_Block_Type implements BlockInterface
{
    /** @var string */
    public $name;

    /** @var Collection */
    public $assets;

    /**
     * Constructor.
     *
     * @param Collection
     * @param ContainerInterface
     */
    public function __construct(
        Collection $collection,
        ContainerInterface $bud
    ) {
        $this->bud = $bud;
        $this->assets = $collection::make([]);
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the block name.
     *
     * @param  string
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = join('/', [
            $this->bud->get('plugin.namespace'),
            $name,
        ]);
    }

    /**
     * Get assets
     *
     * @return Collection $assets
     */
    public function getAssets(): Collection
    {
        return $this->assets;
    }

    /**
     * Set assets
     *
     * @return void
     */
    public function setAssets(Collection $assets): void
    {
        $assets->each(function (AssetInterface $asset) {
            if ($asset->getContext() == 'editor') {
                $context = join('_', [$asset->getContext(), $asset->getType()]);
            } else {
                $context = $asset->getType();
            }

            $this->assets->put($context, $asset);
        });
    }

    /**
     * Register block.
     *
     * @return void
     */
     public function register(): void
     {
         $this->assets->each(function (AssetInterface $asset, string $context) {
             $this->{$context} = $asset->getName();
         });

         register_block_type($this);
     }
}
