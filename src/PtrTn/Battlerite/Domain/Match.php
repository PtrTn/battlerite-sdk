<?php

namespace BattleRite\Domain;

use DateTime;

class Match
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $duration;

    /**
     * @var string
     */
    private $gameType;

    /**
     * @var Teams
     */
    private $teams;

    /**
     * @var Rounds
     */
    private $rounds;

    public function __construct(
        string $id,
        DateTime $createdAt,
        int $duration,
        string $gameType,
        Teams $teams,
        Rounds $rounds
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->duration = $duration;
        $this->gameType = $gameType;
        $this->teams = $teams;
        $this->rounds = $rounds;
    }
}
