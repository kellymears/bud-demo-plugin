<?php

namespace AcmeCo\Plugin;

/**
 * The plugin deactivation class.
 */
class Deactivate
{
    /**
     * Deactivate the plugin.
     *
     * @return void
     */
    public function __invoke(): void
    {
        \flush_rewrite_rules();
    }
}
