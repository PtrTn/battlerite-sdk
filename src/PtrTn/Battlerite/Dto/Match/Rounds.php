<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Rounds implements IteratorAggregate, Countable
{
    /**
     * @var Round[]
     */
    public $rounds;

    public function __construct(array $rounds)
    {
        Assert::allIsInstanceOf($rounds, Round::class);

        $this->rounds = $rounds;
    }

    public static function createFromArray(array $rounds): self
    {
        $createdRounds = [];
        foreach ($rounds as $round) {
            $createdRounds[] = Round::createFromArray($round);
        }
        return new self($createdRounds);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rounds);
    }

    public function count(): int
    {
        return count($this->rounds);
    }
}
