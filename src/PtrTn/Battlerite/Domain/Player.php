<?php

namespace BattleRite\Domain;

class Player
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $champion;

    /**
     * @var int
     */
    private $abilityUses;

    /**
     * @var int
     */
    private $damageDone;

    /**
     * @var int
     */
    private $damageReceived;

    /**
     * @var int
     */
    private $deaths;

    /**
     * @var int
     */
    private $disablesDone;

    /**
     * @var int
     */
    private $disablesReceived;

    /**
     * @var int
     */
    private $emote;

    /**
     * @var int
     */
    private $energyGained;

    /**
     * @var int
     */
    private $energyUsed;

    /**
     * @var int
     */
    private $healingDone;

    /**
     * @var int
     */
    private $healingReceived;

    /**
     * @var int
     */
    private $kills;

    /**
     * @var int
     */
    private $mount;

    /**
     * @var int
     */
    private $outfit;

    /**
     * @var int
     */
    private $score;

    /**
     * @var int
     */
    private $side;

    /**
     * @var int
     */
    private $timeAlive;

    public function __construct(
        string $id,
        string $champion,
        int $abilityUses,
        int $damageDone,
        int $damageReceived,
        int $deaths,
        int $disablesDone,
        int $disablesReceived,
        int $emote,
        int $energyGained,
        int $energyUsed,
        int $healingDone,
        int $healingReceived,
        int $kills,
        int $mount,
        int $outfit,
        int $score,
        int $side,
        int $timeAlive
    ) {
        $this->id = $id;
        $this->champion = $champion;
        $this->abilityUses = $abilityUses;
        $this->damageDone = $damageDone;
        $this->damageReceived = $damageReceived;
        $this->deaths = $deaths;
        $this->disablesDone = $disablesDone;
        $this->disablesReceived = $disablesReceived;
        $this->emote = $emote;
        $this->energyGained = $energyGained;
        $this->energyUsed = $energyUsed;
        $this->healingDone = $healingDone;
        $this->healingReceived = $healingReceived;
        $this->kills = $kills;
        $this->mount = $mount;
        $this->outfit = $outfit;
        $this->score = $score;
        $this->side = $side;
        $this->timeAlive = $timeAlive;
    }
}
