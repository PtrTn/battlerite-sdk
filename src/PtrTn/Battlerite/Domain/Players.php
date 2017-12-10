<?php

namespace BattleRite\Domain;

class Players
{
    /**
     * @var array
     */
    private $players;

    public function __construct(
        array $players
    ) {
        $this->players = $players;
    }
}
