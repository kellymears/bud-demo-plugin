<?php

namespace AcmeCo\Plugin;

/**
 * The plugin activation class.
 */
class Activate
{
    /**
     * Activate the plugin.
     *
     * @return void
     */
    public function __invoke(): void
    {
        \flush_rewrite_rules();
    }
}
