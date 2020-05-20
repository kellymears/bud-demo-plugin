<?php

namespace BudDemoPlugin\Block\Contract;

use Illuminate\Support\Collection;
use BudDemoPlugin\Block\Contract\BlockInterface;

/**
 * Block repository interface.
 */
interface BlockRepositoryInterface
{
    public function get(string $handle): BlockInterface;

    public function all(): Collection;

    public function add(BlockInterface $block): void;

    public function remove(BlockInterface $block): void;
}
