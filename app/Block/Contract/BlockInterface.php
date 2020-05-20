<?php

namespace BudDemoPlugin\Block\Contract;

use Illuminate\Support\Collection;

/**
 * Block class interface.
 */
interface BlockInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getAssets(): Collection;

    public function setAssets(Collection $assets): void;

    public function register(): void;
}
