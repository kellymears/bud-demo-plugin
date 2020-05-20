<?php

namespace BudDemoPlugin\Block;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;
use BudDemoPlugin\Block\Contract\BlockRepositoryInterface;

/**
 * Block Repository class.
 */
class BlockRepository implements BlockRepositoryInterface
{
    /** @var Collection */
    private $blocks;

    /**
     * Construct.
     *
     * @param ContainerInterface
     */
    public function __construct(Collection $collection)
    {
        $this->blocks = $collection::make([]);
    }

    /**
     * Get block.
     *
     * @param  string
     * @return BlockInterface
     */
    public function get(string $handle): BlockInterface
    {
        return $this->blocks->get($handle);
    }

    /**
     * Get blocks.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->blocks;
    }

    /**
     * Add block.
     *
     * @param  BlockInterface
     * @return void
     */
    public function add(BlockInterface $block): void
    {
        $this->blocks->put($block->getName(), $block);
    }

    /**
     * Remove block.
     *
     * @param  BlockInterface
     * @return void
     */
    public function remove(BlockInterface $block): void
    {
        $this->blocks->forget($name);
    }
}
