<?php

namespace PtrTn\Battlerite\Dto;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Webmozart\Assert\Assert;

abstract class CollectionDto implements IteratorAggregate, Countable, ArrayAccess
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

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }
}
