<?php

namespace BattleRite\Domain;

class Round
{
    /**
     * @var int
     */
    private $duration;

    /**
     * @var int
     */
    private $winningTeam;

    public function __construct(
        int $duration,
        int $winningTeam
    ) {
        $this->duration = $duration;
        $this->winningTeam = $winningTeam;
    }
}
