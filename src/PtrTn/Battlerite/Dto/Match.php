<?php

namespace PtrTn\Battlerite\Dto;

use DateTime;
use Webmozart\Assert\Assert;

class Match
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
     * @var DateTime
     */
    public $createdAt;
    /**
     * @var int
     */
    public $duration;
    /**
     * @var string
     */
    public $gameMode;
    /**
     * @var string
     */
    public $patchVersion;
    /**
     * @var string
     */
    public $shardId;
    /**
     * @var Map
     */
    public $map;
    /**
     * @var Assets
     */
    public $assets;
    /**
     * @var Rosters
     */
    public $rosters;
    /**
     * @var Rounds
     */
    public $rounds;
    /**
     * @var Spectators
     */
    public $spectators;
    /**
     * @var string
     */
    public $titleId;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    private function __construct(
        string $type,
        string $id,
        DateTime $createdAt,
        int $duration,
        string $gameMode,
        string $patchVersion,
        string $shardId,
        Map $map,
        Assets $assets,
        Rosters $rosters,
        Rounds $rounds,
        Spectators $spectators,
        string $titleId
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->duration = $duration;
        $this->gameMode = $gameMode;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->map = $map;
        $this->assets = $assets;
        $this->rosters = $rosters;
        $this->rounds = $rounds;
        $this->spectators = $spectators;
        $this->titleId = $titleId;
    }

    public static function createFromArray(array $match): self
    {
        Assert::string($match['type']);
        Assert::string($match['id']);
        Assert::string($match['attributes']['createdAt']);
        Assert::integer($match['attributes']['duration']);
        Assert::string($match['attributes']['gameMode']);
        Assert::string($match['attributes']['patchVersion']);
        Assert::string($match['attributes']['shardId']);
        Assert::isArray($match['attributes']['stats']);
        Assert::isArray($match['relationships']['assets']['data']);
        Assert::isArray($match['relationships']['rosters']['data']);
        Assert::isArray($match['relationships']['rounds']['data']);
        Assert::isArray($match['relationships']['spectators']['data']);
        Assert::string($match['attributes']['titleId']);

        return new self(
            $match['type'],
            $match['id'],
            new DateTime($match['attributes']['createdAt']),
            $match['attributes']['duration'],
            $match['attributes']['gameMode'],
            $match['attributes']['patchVersion'],
            $match['attributes']['shardId'],
            Map::createFromArray($match['attributes']['stats']),
            Assets::createFromArray($match['relationships']['assets']['data']),
            Rosters::createFromArray($match['relationships']['rosters']['data']),
            Rounds::createFromArray($match['relationships']['rounds']['data']),
            Spectators::createFromArray($match['relationships']['spectators']['data']),
            $match['attributes']['titleId']
        );
    }
}
