<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Rounds
{
    /**
     * @var Round[]
     */
    public $rounds;

    private function __construct(array $rounds)
    {
        Assert::allIsInstanceOf($rounds, Round::class);

        $this->rounds = $rounds;
    }

    public static function createFromArray(array $rounds): self
    {
        $createdRounds = [];
        foreach ($rounds as $round) {
            $createdRounds[] = Round::createFromArray($round);
        }
        return new self($createdRounds);
    }
}
