<?php

namespace BudDemoPlugin\Plugin;

/**
 * The plugin deactivation class.
 */
class Deactivate
{
    /**
     * Deactivate the plugin.
     */
    public function __invoke(): void
    {
        \flush_rewrite_rules();
    }
}
