<?php

namespace BattleRite\Domain;

class Team
{
    /**
     * @var Players
     */
    private $players;

    /**
     * @var bool
     */
    private $won;

    public function __construct(
        Players $players,
        bool $won
    ) {
        $this->players = $players;
        $this->won = $won;
    }
}
