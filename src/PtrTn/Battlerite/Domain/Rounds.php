<?php

namespace BattleRite\Domain;

class Rounds
{
    /**
     * @var array
     */
    private $rounds;

    public function __construct(
        array $rounds
    ) {
        $this->rounds = $rounds;
    }
}
