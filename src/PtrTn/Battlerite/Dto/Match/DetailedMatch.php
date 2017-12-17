<?php

namespace PtrTn\Battlerite\Dto\Match;

use DateTime;
use PtrTn\Battlerite\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class DetailedMatch
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
     * @var string
     */
    public $titleId;
    
    /**
     * @var Map
     */
    public $map;
    
    /**
     * @var Assets
     */
    public $assets;

    /**
     * @var Spectators
     */
    public $spectators;

    /**
     * @var Rosters
     */
    public $rosters;

    /**
     * @var Rounds
     */
    public $rounds;

    /**
     * @var Participants
     */
    public $participants;
    
    /**
     * @var Players
     */
    public $players;

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
        string $titleId,
        Map $map,
        Assets $assets,
        Spectators $spectators,
        Rosters $rosters,
        Rounds $rounds,
        Participants $participants,
        Players $players
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->duration = $duration;
        $this->gameMode = $gameMode;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->titleId = $titleId;
        $this->map = $map;
        $this->assets = $assets;
        $this->spectators = $spectators;
        $this->rosters = $rosters;
        $this->rounds = $rounds;
        $this->participants = $participants;
        $this->players = $players;
    }

    public static function createFromArray(array $match): self
    {
        $matchData = $match['data'];
        Assert::string($matchData['type']);
        Assert::string($matchData['id']);
        Assert::date($matchData['attributes']['createdAt'], DateTime::ISO8601);
        Assert::integer($matchData['attributes']['duration']);
        Assert::string($matchData['attributes']['gameMode']);
        Assert::string($matchData['attributes']['patchVersion']);
        Assert::string($matchData['attributes']['shardId']);
        Assert::isArray($matchData['attributes']['stats']);
        Assert::string($matchData['attributes']['titleId']);
        Assert::isArray($matchData['relationships']['assets']['data']);
        Assert::isArray($matchData['relationships']['rosters']['data']);
        Assert::isArray($matchData['relationships']['rounds']['data']);
        Assert::isArray($matchData['relationships']['spectators']['data']);

        $matchIncludes = $match['included'];

        $participants = [];
        $rosters = [];
        $rounds = [];
        $players = [];
        foreach ($matchIncludes as $include) {
            Assert::string($include['type']);
            switch ($include['type']) {
                case 'participant':
                    $participants[] = Participant::createFromArray($include);
                    break;
                case 'roster':
                    $rosters[] = Roster::createFromArray($include);
                    break;
                case 'round':
                    $rounds[] = Round::createFromArray($include);
                    break;
                case 'player':
                    $players[] = Player::createFromArray($include);
                    break;
            }
        }

        return new self(
            $matchData['type'],
            $matchData['id'],
            DateTime::createFromFormat(DateTime::ISO8601, $matchData['attributes']['createdAt']),
            $matchData['attributes']['duration'],
            $matchData['attributes']['gameMode'],
            $matchData['attributes']['patchVersion'],
            $matchData['attributes']['shardId'],
            $matchData['attributes']['titleId'],
            Map::createFromArray($matchData['attributes']['stats']),
            Assets::createFromArray($matchData['relationships']['assets']['data']),
            Spectators::createFromArray($matchData['relationships']['spectators']['data']),
            new Rosters($rosters),
            new Rounds($rounds),
            new Participants($participants),
            new Players($players)
        );
    }

    public function getParticipantByPlayerId(string $playerId): ?Participant
    {
        foreach ($this->participants as $participant) {
            if ($participant->userID === $playerId) {
                return $participant;
            }
        }
        return null;
    }

    public function hasPlayerWon(string $playerId): bool
    {
        $participant = $this->getParticipantByPlayerId($playerId);
        return $this->rosters->hasParticipantWon($participant);
    }
}
