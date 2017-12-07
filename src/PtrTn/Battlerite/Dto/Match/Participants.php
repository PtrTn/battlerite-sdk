<?php

namespace PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\CollectionDto;
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
}
