<?php

namespace BudDemoPlugin\Asset\Base;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\CollectionInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;

/**
 * Abstract Asset Collection
 */
abstract class AbstractCollection extends Collection implements CollectionInterface
{
    /** @var static string */
    public $localhost = '//localhost:3030';

    /** @var bool */
    public $dev;

    /**
     * Return assets of type
     *
     * @param  string type
     * @return static CollectionInterface
     */
    public function ofType(string $type): CollectionInterface
    {
        $items = $this->make($this->items)
            ->where('type', $type)
            ->unique()
            ->groupBy($type);

        return new static ($items);
    }

    /**
     * Return registered assets.
     */
    public function registered()
    {
        $items = $this->make($this->items)
            ->where('registered', true);

        return new static ($items);
    }

    /**
     * Return WP registration fields.
     */
    public function registration()
    {
        $items = $this->make([
            $this->items['name'],
            $this->items['url'],
            $this->items['dependencies'],
            $this->items['version'],
        ]);

        return new static ($items);
    }

    /**
     * From JSON
     *
     * @param  ContainerInterface
     * @param  string
     * @return Collection
     */
    public function fromFile(
        ContainerInterface $bud,
        string $manifest = '/dist/manifest.json'
    ) {
        /** Final collection */
        $assets = $this->make([]);

        $this->plugin = (object) [
            'url' => $bud->get('plugin.url'),
            'path' => $bud->get('path.plugin'),
            'namespace' => $bud->get('plugin.namespace'),
        ];

        $this->collectFromJson($manifest)->each(
            function ($path) use ($assets) {
                /** Determine env */
                $this->dev = strpos($path, $this->localhost) ? true : false;
                $pluginRelativePath = str_replace($this->localhost, '', $path);

                /** Explode the path into known units. */
                [, , $type, $name, $file] = explode('/', $pluginRelativePath);
                $components = $this->make(explode('.', $file));
                $extension = $components->pop();
                $hook = $components->shift();
                $version = $components->shift();

                /**
                 * Bounce early if we have a manifest or map or
                 * other unspecified artifact.
                 */
                if ($extension == "map" || $extension == "json") {
                    return;
                }

                /** Gather dependencies */
                $dependencies = $this->collectFromJson(
                    str_replace(".{$extension}", ".asset.json", $pluginRelativePath)
                )->get('dependencies');

                /**
                 * Push entry.
                 */
                $assets->push($this->make([
                    'block' => "{$this->plugin->namespace}/{$name}",
                    'name' => "{$this->plugin->namespace}/{$name}/{$hook}",
                    'url' => $this->url($pluginRelativePath),
                    'type' => $type == 'blocks' ? 'block' : 'asset',
                    'file' => $file,
                    'hook' => $hook,
                    'version' => null,
                    'extension' => $extension,
                    'dependencies' => $dependencies,
                ]));
            }
        );

        return new static($assets);
    }

    /**
     * Plugin url.
     *
     * @param  string relativePath
     * @return string
     */
    private function url(string $pluginRelativePath): string
    {
        $base = $this->dev ? $this->localhost : $this->plugin->url;

        return "{$base}{$pluginRelativePath}";
    }

    /**
     * Plugin path.
     *
     * @param  string relativePath
     * @return string
     */
    private function path(string $pluginRelativePath): string
    {
        return realpath("{$this->plugin->path}{$pluginRelativePath}");
    }

    /**
     * Collect from JSON.
     *
     * @param  string path
     * @return CollectionInterface
     */
    private function collectFromJson(string $pluginRelativePath)
    {
        $contents = $this->path($pluginRelativePath)
            ? json_decode(file_get_contents($this->path($pluginRelativePath)))
            : [];

        return $this->make($contents);
    }
}
