<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Participants implements IteratorAggregate, Countable
{
    /**
     * @var Participant[]
     */
    public $participants;

    public function __construct(array $participants)
    {
        Assert::allIsInstanceOf($participants, Participant::class);

        $this->participants = $participants;
    }

    public static function createFromArray(array $participants): self
    {
        Assert::notNull($participants);

        $createdParticipants = [];
        foreach ($participants as $participant) {
            $createdParticipants[] = Participant::createFromArray($participant);
        }
        return new self($createdParticipants);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->participants);
    }

    public function count(): int
    {
        return count($this->participants);
    }
}
