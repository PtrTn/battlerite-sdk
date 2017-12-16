<?php

namespace PtrTn\Battlerite\Dto\Match;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Participants extends CollectionDto
{
    /**
     * @var Participant[]
     */
    public $items;

    public function __construct(array $participants)
    {
        parent::__construct(Participant::class, $participants);
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

    /**
     * @return Traversable|Participant[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
