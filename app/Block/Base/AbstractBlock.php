<?php

namespace BudDemoPlugin\Block\Base;

use \WP_Block_Type;
use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;

/**
 * Block class.
 */
abstract class AbstractBlock extends WP_Block_Type implements BlockInterface, ContainerInterface {
    /** @var string */
    public $name = null;

    /** @var string */
    public $script = null;

    /** @var string */
    public $style = null;

    /** @var string */
    public $editor_script = null;

    /** @var string */
    public $editor_style = null;

    /** @var array */
    public $attributes = [];

    /** @var string */
    public $render_callback = null;

    /**
     * Constructor.
     *
     * @param Collection
     * @param ContainerInterface
     */
    public function __construct(
        ContainerInterface $bud,
        string $name
    ) {
        $this->bud = $bud;
        $this->name = $name;
    }

    /**
     * Get a block property.
     *
     * @param  string id
     * @return mixed
     */
    public function get($id)
    {
        return $this->{$id};
    }

    /**
     * Set a block asset
     *
     * @param  string
     * @return void
     */
    public function set(string $property, string $name): void
    {
        $this->{$property} = $name;
    }

    /**
     * Has a block asset
     *
     * @param  string
     * @return bool
     */
     public function has($id): bool
     {
         return property_exists($this, $id);
     }
}