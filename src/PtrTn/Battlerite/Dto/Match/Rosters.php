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

    public function getWinningRoster(): ?Roster
    {
        foreach ($this->items as $roster) {
            if ($roster->won === true) {
                return $roster;
            }
        }
        return null;
    }

    /**
     * Returns true if participant was victorious
     * Returns false if opponent was victorious
     * Returns null if nobody is victorious
     */
    public function hasParticipantWon(Participant $participant): ?bool
    {
        $winningRoster = $this->getWinningRoster();
        if ($winningRoster === null) {
            return null;
        }

        foreach ($winningRoster->participants as $winningParticipant) {
            if ($winningParticipant->id === $participant->id) {
                return true;
            }
        }
        return false;
    }
}
