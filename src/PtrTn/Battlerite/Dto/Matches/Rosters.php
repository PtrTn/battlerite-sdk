<?php

namespace PtrTn\Battlerite\Dto\Matches;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Rosters implements IteratorAggregate, Countable
{
    /**
     * @var Roster[]
     */
    public $rosters;

    public function __construct(array $rosters)
    {
        Assert::allIsInstanceOf($rosters, Roster::class);

        $this->rosters = $rosters;
    }

    public static function createFromArray(array $rosters): self
    {
        $createdRosters = [];
        foreach ($rosters as $roster) {
            $createdRosters[] = Roster::createFromArray($roster);
        }
        return new self($createdRosters);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rosters);
    }

    public function count(): int
    {
        return count($this->rosters);
    }
}
