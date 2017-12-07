<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Spectators implements IteratorAggregate, Countable
{
    /**
     * @var Spectator[]
     */
    public $spectators;

    private function __construct(array $spectators)
    {
        Assert::allIsInstanceOf($spectators, Spectator::class);

        $this->spectators = $spectators;
    }

    public static function createFromArray(array $spectators): self
    {
        $createdSpectators = [];
        foreach ($spectators as $spectator) {
            $createdSpectators[] = Spectator::createFromArray($spectator);
        }
        return new self($createdSpectators);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->spectators);
    }

    public function count(): int
    {
        return count($this->spectators);
    }
}
