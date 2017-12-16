<?php

namespace PtrTn\Battlerite\Dto\Matches;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Assets extends CollectionDto
{
    /**
     * @var Asset[]
     */
    public $items;

    protected function __construct(array $assets)
    {
        parent::__construct(Asset::class, $assets);
    }

    public static function createFromArray(array $assets): self
    {
        Assert::notNull($assets);

        $createdAssets = [];
        foreach ($assets as $asset) {
            $createdAssets[] = Asset::createFromArray($asset);
        }
        return new self($createdAssets);
    }

    /**
     * @return Traversable|Asset[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
