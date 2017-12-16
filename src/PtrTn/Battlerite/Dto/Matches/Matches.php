<?php

namespace PtrTn\Battlerite\Dto\Matches;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Matches extends CollectionDto
{
    /**
     * @var Match[]
     */
    public $items;

    protected function __construct(array $matches)
    {
        parent::__construct(Match::class, $matches);
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

    /**
     * @return Traversable|Match[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
