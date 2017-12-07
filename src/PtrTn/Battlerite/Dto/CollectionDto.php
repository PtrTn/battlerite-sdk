<?php

namespace PtrTn\Battlerite\Dto;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

abstract class CollectionDto implements IteratorAggregate, Countable
{
    /**
     * @var array
     */
    public $items;

    protected function __construct(string $class, array $items)
    {
        Assert::allIsInstanceOf($items, $class);

        $this->items = $items;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
