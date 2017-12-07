<?php

namespace PtrTn\Battlerite\Dto\Matches;

use Webmozart\Assert\Assert;

class Assets
{
    /**
     * @var Asset[]
     */
    public $assets;

    private function __construct(array $assets)
    {
        Assert::allIsInstanceOf($assets, Asset::class);

        $this->assets = $assets;
    }

    public static function createFromArray(array $assets): self
    {
        $createdAssets = [];
        foreach ($assets as $asset) {
            $createdAssets[] = Asset::createFromArray($asset);
        }
        return new self($createdAssets);
    }
}
