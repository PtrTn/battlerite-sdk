<?php

namespace PtrTn\Battlerite\Dto;

use Countable;
use IteratorAggregate;
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

    public function count(): int
    {
        return count($this->items);
    }
}
