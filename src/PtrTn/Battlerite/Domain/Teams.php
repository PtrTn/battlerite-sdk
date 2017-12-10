<?php

namespace BattleRite\Domain;

class Teams
{
    /**
     * @var array
     */
    private $teams;

    public function __construct(
        array $teams
    ) {
        $this->teams = $teams;
    }
}
