<?php

namespace BudDemoPlugin\Asset\Base;

use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;

/**
 * Abstract Asset class.
 */
abstract class AbstractAsset implements AssetInterface
{
    /** @var string */
    public $name;

    /** @var string */
    public $type;

    /** @var string */
    public $url;

    /** @var array */
    public $dependencies;

    /**
     * Constructor.
     */
    public function __construct(ContainerInterface $bud)
    {
        $this->bud = $bud;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param  string
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @return string
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Get context
     *
     * @return string
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Set context
     *
     * @param  string $context
     * @return void
     */
    public function setContext(string $context): void
    {
        $this->context = $context;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set url.
     *
     * @return string
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Get dependencies.
     *
     * @param  string
     * @return void
     */
    public function getDependencies(): array
    {
        if ($this->getType() == 'style') {
            return [];
        }

        return $this->dependencies ?? [];
    }

    /**
     * Set dependencies.
     *
     * @param  string
     * @param  string
     * @return void
     */
    public function setDependencies(array $dependencies): void
    {
        $this->dependencies = $dependencies;
    }

    /**
     * Register asset.
     *
     * @return void
     */
    public function register(): void
    {
         if ($this->getType() == 'script') {
            wp_register_script($this->getName(), $this->getUrl(), $this->getDependencies(), null);
         } else {
            wp_register_style($this->getName(), $this->getUrl(), [], null);
         }
    }
}
