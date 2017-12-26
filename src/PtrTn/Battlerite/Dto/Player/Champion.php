<?php

namespace PtrTn\Battlerite\Dto\Player;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class Champion
{
    /**
     * @var string
     */
    public $devName;

    /**
     * @var int|null
     */
    public $xp;

    /**
     * @var int|null
     */
    public $level;

    /**
     * @var mixed|null
     */
    public $wins;

    /**
     * @var mixed|null
     */
    public $losses;

    /**
     * @var mixed|null
     */
    public $kills;

    /**
     * @var mixed|null
     */
    public $deaths;

    /**
     * @var mixed|null
     */
    public $timePlayed;

    /**
     * @var mixed|null
     */
    public $ranked2v2Wins;

    /**
     * @var mixed|null
     */
    public $ranked2v2Losses;

    /**
     * @var mixed|null
     */
    public $ranked3v3Wins;

    /**
     * @var mixed|null
     */
    public $ranked3v3Losses;

    /**
     * @var mixed|null
     */
    public $unranked2v2Wins;

    /**
     * @var mixed|null
     */
    public $unranked2v2Losses;

    /**
     * @var mixed|null
     */
    public $unranked3v3Wins;

    /**
     * @var mixed|null
     */
    public $unranked3v3Losses;

    /**
     * @var mixed|null
     */
    public $brawlWins;

    /**
     * @var mixed|null
     */
    public $brawlLosses;

    /**
     * @var mixed|null
     */
    public $battlegroundsWins;

    /**
     * @var mixed|null
     */
    public $battlegroundsLosses;

    private function __construct()
    {
    }

    public static function createFromArray(string $championName, array $championStats): self
    {
        $champ = new self();
        $champ->devName = $championName;
        $champ->xp = $championStats['XP'] ?? null;
        $champ->level = $championStats['Level'] ?? null;
        $champ->wins = $championStats['Wins'] ?? null;
        $champ->losses = $championStats['Losses'] ?? null;
        $champ->kills = $championStats['Kills'] ?? null;
        $champ->deaths = $championStats['Deaths'] ?? null;
        $champ->timePlayed = $championStats['TimePlayed'] ?? null;
        $champ->ranked2v2Wins = $championStats['Ranked2v2Wins'] ?? null;
        $champ->ranked2v2Losses = $championStats['Ranked2v2Losses'] ?? null;
        $champ->ranked3v3Wins = $championStats['Ranked3v3Wins'] ?? null;
        $champ->ranked3v3Losses = $championStats['Ranked3v3Losses'] ?? null;
        $champ->unranked2v2Wins = $championStats['Unranked2v2Wins'] ?? null;
        $champ->unranked2v2Losses = $championStats['Unranked2v2Losses'] ?? null;
        $champ->unranked3v3Wins = $championStats['Unranked3v3Wins'] ?? null;
        $champ->unranked3v3Losses = $championStats['Unranked3v3Losses'] ?? null;
        $champ->brawlWins = $championStats['BrawlWins'] ?? null;
        $champ->brawlLosses = $championStats['BrawlLosses'] ?? null;
        $champ->battlegroundsWins = $championStats['BattlegroundsWins'] ?? null;
        $champ->battlegroundsLosses = $championStats['BattlegroundsLosses'] ?? null;

        return $champ;
    }
}
