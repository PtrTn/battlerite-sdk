<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use RuntimeException;
use Traversable;
use Webmozart\Assert\Assert;

class Rosters extends CollectionDto
{
    /**
     * @var Roster[]
     */
    public $items;

    public function __construct(array $rosters)
    {
        parent::__construct(Roster::class, $rosters);
    }

    public static function createFromArray(array $rosters): self
    {
        Assert::notNull($rosters);

        $createdRosters = [];
        foreach ($rosters as $roster) {
            $createdRosters[] = Roster::createFromArray($roster);
        }
        return new self($createdRosters);
    }

    /**
     * @return Traversable|Roster[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function getWinningParticipants(): References
    {
        foreach ($this->items as $roster) {
            if ($roster->won === true) {
                return $roster->participants;
            }
        }
        throw new RuntimeException('Invalid data, match should always have a victor');
    }
}
