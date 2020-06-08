<?php

namespace BudDemoPlugin\Block\Contract;

/**
 * Block class interface.
 */
interface BlockInterface
{
    public function get($id);

    public function set(string $property, string $name): void;

    public function has($id): bool;
}
