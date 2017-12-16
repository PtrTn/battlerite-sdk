<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Spectators extends CollectionDto
{
    /**
     * @var Spectator[]
     */
    public $items;

    protected function __construct(array $spectators)
    {
        parent::__construct(Spectator::class, $spectators);
    }

    public static function createFromArray(array $spectators): self
    {
        Assert::notNull($spectators);

        $createdSpectators = [];
        foreach ($spectators as $spectator) {
            $createdSpectators[] = Spectator::createFromArray($spectator);
        }
        return new self($createdSpectators);
    }

    /**
     * @return Traversable|Spectator[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
