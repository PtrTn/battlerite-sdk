<?php

namespace PtrTn\Battlerite\Dto\Teams;

use DateTime;
use PtrTn\Battlerite\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class Team
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $titleId;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $shardId;

    /**
     * @var int
     */
    public $avatar;

    /**
     * @var int
     */
    public $division;

    /**
     * @var int
     */
    public $divisionRating;

    /**
     * @var int
     */
    public $league;

    /**
     * @var int
     */
    public $losses;

    /**
     * @var Members
     */
    public $members;

    /**
     * @var int
     */
    public $placementGamesLeft;

    /**
     * @var int
     */
    public $topDivision;

    /**
     * @var int
     */
    public $topDivisionRating;

    /**
     * @var int
     */
    public $topLeague;

    /**
     * @var int
     */
    public $wins;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    private function __construct(
        string $type,
        string $id,
        string $name,
        string $shardId,
        int $avatar,
        int $division,
        int $divisionRating,
        int $league,
        int $losses,
        Members $members,
        int $placementGamesLeft,
        int $topDivision,
        int $topDivisionRating,
        int $topLeague,
        int $wins,
        string $titleId
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->shardId = $shardId;
        $this->avatar = $avatar;
        $this->division = $division;
        $this->divisionRating = $divisionRating;
        $this->league = $league;
        $this->losses = $losses;
        $this->members = $members;
        $this->placementGamesLeft = $placementGamesLeft;
        $this->topDivision = $topDivision;
        $this->topDivisionRating = $topDivisionRating;
        $this->topLeague = $topLeague;
        $this->wins = $wins;
        $this->titleId = $titleId;
    }

    public static function createFromArray(array $match): self
    {
        Assert::string($match['type']);
        Assert::string($match['id']);
        Assert::string($match['attributes']['name']);
        Assert::string($match['attributes']['shardId']);
        Assert::integer($match['attributes']['stats']['avatar']);
        Assert::integer($match['attributes']['stats']['division']);
        Assert::integer($match['attributes']['stats']['divisionRating']);
        Assert::integer($match['attributes']['stats']['league']);
        Assert::integer($match['attributes']['stats']['losses']);
        Assert::integer($match['attributes']['stats']['placementGamesLeft']);
        Assert::integer($match['attributes']['stats']['topDivision']);
        Assert::integer($match['attributes']['stats']['topDivisionRating']);
        Assert::integer($match['attributes']['stats']['topLeague']);
        Assert::integer($match['attributes']['stats']['wins']);
        Assert::string($match['attributes']['titleId']);

        return new self(
            $match['type'],
            $match['id'],
            $match['attributes']['name'],
            $match['attributes']['shardId'],
            $match['attributes']['stats']['avatar'],
            $match['attributes']['stats']['division'],
            $match['attributes']['stats']['divisionRating'],
            $match['attributes']['stats']['league'],
            $match['attributes']['stats']['losses'],
            Members::createFromArray($match['attributes']['stats']['members']),
            $match['attributes']['stats']['placementGamesLeft'],
            $match['attributes']['stats']['topDivision'],
            $match['attributes']['stats']['topDivisionRating'],
            $match['attributes']['stats']['topLeague'],
            $match['attributes']['stats']['wins'],
            $match['attributes']['titleId']
        );
    }
}
