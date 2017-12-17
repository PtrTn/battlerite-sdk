<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use PtrTn\Battlerite\Assert\Assert;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;

class References extends CollectionDto
{
    /**
     * @var Reference[]
     */
    public $items;

    public function __construct(array $references)
    {
        parent::__construct(Reference::class, $references);
    }

    public static function createFromArray(array $references): self
    {
        Assert::notNull($references);

        $createdReferences = [];
        foreach ($references as $reference) {
            $createdReferences[] = Reference::createFromArray($reference);
        }
        return new self($createdReferences);
    }

    /**
     * @return Traversable|Reference[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
