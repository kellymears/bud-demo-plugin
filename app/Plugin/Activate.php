<?php

namespace BudDemoPlugin\Plugin;

/**
 * The plugin activation class.
 */
class Activate
{
    /**
     * Activate the plugin.
     */
    public function __invoke(): void
    {
        \flush_rewrite_rules();
    }
}
