<?php

namespace Roots\Bud\Plugin;

use Psr\Container\ContainerInterface;

/**
 * Plugin init.
 */
class Init
{
    /**
     * Class constructor.
     *
     * @param  ContainerInterface $bud
     */
    public function __construct(ContainerInterface $bud)
    {
        $this->bud = $bud;
    }

    /**
     * Class invocation.
     */
    public function __invoke(): void
    {
        $this->bud->has('plugin.main') && $this->bud->make('plugin.main')($this->bud);
    }
}
