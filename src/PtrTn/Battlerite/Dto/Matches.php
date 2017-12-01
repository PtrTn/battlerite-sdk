<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Matches
{
    /**
     * @var Match[]
     */
    public $matches;

    private function __construct(array $matches)
    {
        Assert::allIsInstanceOf($matches, Match::class);

        $this->matches = $matches;
    }

    public static function createFromArray(array $matches): self
    {
        Assert::notNull($matches['data']);

        $createdMatches = [];
        foreach ($matches['data'] as $match) {
            $createdMatches[] = Match::createFromArray($match);
        }
        return new self($createdMatches);
    }
}
