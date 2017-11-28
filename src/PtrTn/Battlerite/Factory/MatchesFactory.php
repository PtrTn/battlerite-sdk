<?php

namespace PtrTn\Battlerite\Factory;

use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Matches;

class MatchesFactory
{
    public static function createMatchesFromArray(array $matchesArray): Matches
    {
        $matches = new Matches();
        foreach ($matchesArray as $matchArray) {
            $matches->addMatch(Match::createFromArray($matchArray));
        }
        return $matches;
    }
}
