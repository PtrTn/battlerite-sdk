<?php

namespace PtrTn\Battlerite\Dto\Player;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Maps extends CollectionDto
{
    /**
     * @var Map[]
     */
    public $items;


    protected function __construct(array $assets)
    {
        parent::__construct(Map::class, $assets);
    }

    public static function createFromArray(array $mapStats): self
    {
        Assert::notNull($mapStats);

        $createdAssets = [];
        foreach ($mapStats as $mapName => $map) {
            $createdAssets[] = Map::createFromArray($mapName, $map);
        }
        return new self($createdAssets);
    }

    /**
     * @return Traversable|Map[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
