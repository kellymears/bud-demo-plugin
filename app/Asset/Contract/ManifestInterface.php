<?php

namespace BudDemoPlugin\Asset\Contract;

use Illuminate\Support\Collection;
use BudDemoPlugin\Block\Contract\BlockInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;

/**
 * Asset Manifest interface.
 */
interface ManifestInterface
{
    public function getAsset(BlockInterface $block, string $context, string $ext): AssetInterface;

    public function getAssets(BlockInterface $block): Collection;

    public function getDependencies(string $name, string $context): array;
}
