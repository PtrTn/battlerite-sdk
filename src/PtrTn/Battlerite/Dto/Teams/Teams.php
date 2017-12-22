<?php

namespace PtrTn\Battlerite\Dto\Teams;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Teams extends CollectionDto
{
    /**
     * @var Team[]
     */
    public $items;

    protected function __construct(array $teames)
    {
        parent::__construct(Team::class, $teames);
    }

    public static function createFromArray(array $teames): self
    {
        Assert::notNull($teames);

        $createdTeames = [];
        foreach ($teames as $team) {
            $createdTeames[] = Team::createFromArray($team);
        }
        return new self($createdTeames);
    }

    /**
     * @return Traversable|Team[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
