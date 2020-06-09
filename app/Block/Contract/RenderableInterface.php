<?php

namespace BudDemoPlugin\Block\Contract;

/**
 * Renderable interface
 */
interface RenderableInterface
{
    public function hasView(): bool;

    public function setView(): void;

    public function renderView(array $attributes): string;
}
