<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Rounds extends CollectionDto
{
    /**
     * @var Round[]
     */
    public $items;

    public function __construct(array $rounds)
    {
        parent::__construct(Round::class, $rounds);
    }

    public static function createFromArray(array $rounds): self
    {
        Assert::notNull($rounds);

        $createdRounds = [];
        foreach ($rounds as $round) {
            $createdRounds[] = Round::createFromArray($round);
        }
        return new self($createdRounds);
    }

    /**
     * @return Traversable|Round[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
