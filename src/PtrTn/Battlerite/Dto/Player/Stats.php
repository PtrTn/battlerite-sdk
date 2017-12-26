<?php

namespace PtrTn\Battlerite\Dto\Player;

class Stats
{
    /**
     * @var int|null
     */
    public $wins;

    /**
     * @var int|null
     */
    public $losses;

    /**
     * @var int|null
     */
    public $gradeScore;

    /**
     * @var int|null
     */
    public $timePlayed;

    /**
     * @var int|null
     */
    public $ranked2v2Wins;

    /**
     * @var int|null
     */
    public $ranked2v2Losses;

    /**
     * @var int|null
     */
    public $ranked3v3Wins;

    /**
     * @var int|null
     */
    public $ranked3v3Losses;

    /**
     * @var int|null
     */
    public $unranked2v2Wins;

    /**
     * @var int|null
     */
    public $unranked2v2Losses;

    /**
     * @var int|null
     */
    public $unranked3v3Wins;

    /**
     * @var int|null
     */
    public $unranked3v3Losses;

    /**
     * @var int|null
     */
    public $brawlWins;

    /**
     * @var int|null
     */
    public $brawlLosses;

    /**
     * @var int|null
     */
    public $battlegroundsWins;

    /**
     * @var int|null
     */
    public $battlegroundsLosses;

    /**
     * @var int|null
     */
    public $accountXP;

    /**
     * @var int|null
     */
    public $accountLevel;

    /**
     * @var mixed|null
     */
    public $twitchAccountLinked;

    /**
     * @var int|null
     */
    public $vsAIPlayed;

    /**
     * @var int|null
     */
    public $ratingMean;

    /**
     * @var int|null
     */
    public $ratingDev;

    /**
     * @var Champions
     */
    public $champions;

    /**
     * @var Maps
     */
    public $maps;

    public static function createFromArray(
        array $accountStats,
        array $championStats,
        array $mapStats
    ): self {
        $stats = new self();
        $stats->wins = $accountStats['Wins'] ?? null;
        $stats->losses = $accountStats['Losses'] ?? null;
        $stats->gradeScore = $accountStats['GradeScore'] ?? null;
        $stats->timePlayed = $accountStats['TimePlayed'] ?? null;
        $stats->ranked2v2Wins = $accountStats['Ranked2v2Wins'] ?? null;
        $stats->ranked2v2Losses = $accountStats['Ranked2v2Losses'] ?? null;
        $stats->ranked3v3Wins = $accountStats['Ranked3v3Wins'] ?? null;
        $stats->ranked3v3Losses = $accountStats['Ranked3v3Losses'] ?? null;
        $stats->unranked2v2Wins = $accountStats['Unranked2v2Wins'] ?? null;
        $stats->unranked2v2Losses = $accountStats['Unranked2v2Losses'] ?? null;
        $stats->unranked3v3Wins = $accountStats['Unranked3v3Wins'] ?? null;
        $stats->unranked3v3Losses = $accountStats['Unranked3v3Losses'] ?? null;
        $stats->brawlWins = $accountStats['BrawlWins'] ?? null;
        $stats->brawlLosses = $accountStats['BrawlLosses'] ?? null;
        $stats->battlegroundsWins = $accountStats['BattlegroundsWins'] ?? null;
        $stats->battlegroundsLosses = $accountStats['BattlegroundsLosses'] ?? null;
        $stats->accountXP = $accountStats['AccountXP'] ?? null;
        $stats->accountLevel = $accountStats['AccountLevel'] ?? null;
        $stats->twitchAccountLinked = $accountStats['TwitchAccountLinked'] ?? null;
        $stats->vsAIPlayed = $accountStats['VsAIPlayed'] ?? null;
        $stats->ratingMean = $accountStats['RatingMean'] ?? null;
        $stats->ratingDev = $accountStats['RatingDev'] ?? null;

        $stats->champions = Champions::createFromArray($championStats);
        $stats->maps = Maps::createFromArray($mapStats);

        return $stats;
    }
}
