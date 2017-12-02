<?php

namespace PtrTn\Battlerite\Dto;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Matches implements IteratorAggregate, Countable
{
    /**
     * @var Match[]
     */
    public $matches;

    private function __construct(array $matches)
    {
        Assert::allIsInstanceOf($matches, Match::class);

        $this->matches = $matches;
    }

    public static function createFromArray(array $matches): self
    {
        Assert::notNull($matches);

        $createdMatches = [];
        foreach ($matches as $match) {
            $createdMatches[] = Match::createFromArray($match);
        }
        return new self($createdMatches);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->matches);
    }

    public function count(): int
    {
        return count($this->matches);
    }
}
