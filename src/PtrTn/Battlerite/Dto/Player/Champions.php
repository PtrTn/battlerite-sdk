<?php

namespace PtrTn\Battlerite\Dto\Player;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Champions extends CollectionDto
{
    /**
     * @var Champion[]
     */
    public $items;


    protected function __construct(array $assets)
    {
        parent::__construct(Champion::class, $assets);
    }

    public static function createFromArray(array $championStats): self
    {
        Assert::notNull($championStats);

        $createdAssets = [];
        foreach ($championStats as $championName => $champion) {
            $createdAssets[] = Champion::createFromArray($championName, $champion);
        }
        return new self($createdAssets);
    }

    /**
     * @return Traversable|Champion[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
