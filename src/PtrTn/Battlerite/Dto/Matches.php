<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Matches
{
    /**
     * @var Match[]
     */
    private $matches;

    public function __construct(array $matches = [])
    {
        Assert::allIsInstanceOf($matches, Match::class);
        $this->matches = $matches;
    }

    public function addMatch(Match $match)
    {
        $this->matches[] = $match;
    }
}
