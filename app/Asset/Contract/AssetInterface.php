<?php

namespace BudDemoPlugin\Asset\Contract;

/**
 * Asset interface.
 */
interface AssetInterface
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getUrl(): string;

    public function setUrl(string $url): void;

    public function getType(): string;

    public function setType(string $type): void;

    public function getContext(): string;

    public function setContext(string $context): void;

    public function getDependencies(): array;

    public function setDependencies(array $dependencies): void;

    public function register(): void;
}
