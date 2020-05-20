<?php

namespace BudDemoPlugin\Asset\Base;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use BudDemoPlugin\Asset\Contract\AssetInterface;
use BudDemoPlugin\Asset\Contract\ManifestInterface;
use BudDemoPlugin\Block\Contract\BlockInterface;

/**
 * Abstract Manifest class.
 */
abstract class AbstractManifest implements ManifestInterface
{
    /** @var ContainerInterface */
    protected $bud;

    /** @var Collection */
    protected $assets;

    /** @var array */
    protected $types = [
        'js' => 'script',
        'css' => 'style',
    ];

    /**
     * Class constructor.
     *
     * @param ContainerInterface $bud
     * @param Collection         $collection
     */
    public function __construct(
        ContainerInterface $bud,
        Collection $collection
    ) {
        $this->bud = $bud;
        $this->collection = $collection;

        $this->assets = $collection::make([]);

        $this->manifestContents = $collection::make(
            $this->bud->get('plugin.manifest')
        );
    }

    /**
     * Get asset.
     *
     * @return AssetInterface
     */
    public function getAsset(BlockInterface $block, string $context, string $ext): AssetInterface
    {
        $blockName = str_replace($this->bud->get('plugin.namespace') . '/', '', $block->getName());
        $asset = $this->bud->make(AssetInterface::class);

        $asset->setType($this->types[$ext]);
        $asset->setContext($context);
        $asset->setName(join('/', [$blockName, $context, $asset->getType()]));
        $asset->setUrl($this->bud->get('plugin.url') . $this->manifestContents->get("{$blockName}/{$context}")->{$ext});

        if ($asset->getType() !== 'style') {
            $asset->setDependencies($this->getDependencies($blockName, $context) ?: []);
        }

        $this->assets->push($asset);

        return $asset;
    }

    /**
     * Get assets.
     *
     * @param  BlockInterface $block
     * @return Collection
     */
    public function getAssets(BlockInterface $block): Collection
    {
        return $this->collection::make([
            $this->getAsset($block, 'editor', 'js'),
            $this->getAsset($block, 'public', 'js'),
            $this->getAsset($block, 'editor', 'css'),
            $this->getAsset($block, 'public', 'css'),
        ]);
    }

    /**
     * Get dependency manifest.
     *
     * @param  string $name
     * @param  string $context
     * @return array
     */
    public function getDependencies(string $name, string $context): array
    {
        $dependencyManifest = join('', [
            $this->bud->get('path.plugin'),
            $this->manifestContents->get("{$name}/{$context}")->json
        ]);

        return $this->collection::make(
            (object) json_decode(file_get_contents($dependencyManifest))
        )->get('dependencies');
    }
}
