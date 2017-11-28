<?php

namespace PtrTn\Battlerite\Dto;

use DateTime;
use Webmozart\Assert\Assert;

class Match
{
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
     * @var string[]
     */
    private $rosterIds;
    /**
     * @var string[]
     */
    private $roundIds;

    private function __construct(
        string $id,
        DateTime $createdAt,
        int $duration,
        string $gameMode,
        string $patchVersion,
        string $shardId,
        array $rosterIds,
        array $roundIds
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->duration = $duration;
        $this->gameMode = $gameMode;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->rosterIds = $rosterIds;
        $this->roundIds = $roundIds;
    }

    public static function createFromArray(array $match)
    {
        Assert::notNull($match['id']);
        Assert::notNull($match['attributes']['createdAt']);
        Assert::notNull($match['attributes']['duration']);
        Assert::notNull($match['attributes']['gameMode']);
        Assert::notNull($match['attributes']['patchVersion']);
        Assert::notNull($match['attributes']['shardId']);

        $rosterIds = [];
        Assert::notNull($match['relationships']['rosters']['data']);
        foreach ($match['relationships']['rosters']['data'] as $roster) {
            Assert::notNull($roster['id']);
            $rosterIds[] = $roster['id'];
        }

        $roundIds = [];
        Assert::notNull($match['relationships']['rounds']['data']);
        foreach ($match['relationships']['rounds']['data'] as $round) {
            Assert::notNull($round['id']);
            $roundIds[] = $round['id'];
        }

        return new self(
            $match['id'],
            new DateTime($match['attributes']['createdAt']),
            $match['attributes']['duration'],
            $match['attributes']['gameMode'],
            $match['attributes']['patchVersion'],
            $match['attributes']['shardId'],
            $rosterIds,
            $roundIds
        );
    }
}
