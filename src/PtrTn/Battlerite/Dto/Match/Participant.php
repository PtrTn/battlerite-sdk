<?php

namespace PtrTn\Battlerite\Dto\Match;

use Webmozart\Assert\Assert;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class Participant
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
    public $actor;

    /**
     * @var string
     */
    public $shardId;

    /**
     * @var int
     */
    public $abilityUses;

    /**
     * @var int
     */
    public $attachment;

    /**
     * @var int
     */
    public $damageDone;

    /**
     * @var int
     */
    public $damageReceived;

    /**
     * @var int
     */
    public $deaths;

    /**
     * @var int
     */
    public $disablesDone;

    /**
     * @var int
     */
    public $disablesReceived;

    /**
     * @var int
     */
    public $emote;

    /**
     * @var int
     */
    public $energyGained;

    /**
     * @var int
     */
    public $energyUsed;

    /**
     * @var int
     */
    public $healingDone;

    /**
     * @var int
     */
    public $healingReceived;

    /**
     * @var int
     */
    public $kills;

    /**
     * @var int
     */
    public $mount;

    /**
     * @var int
     */
    public $outfit;

    /**
     * @var int
     */
    public $score;

    /**
     * @var int
     */
    public $side;

    /**
     * @var int
     */
    public $timeAlive;

    /**
     * @var string
     */
    public $userID;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    private function __construct(
        string $type,
        string $id,
        string $actor,
        string $shardId,
        int $abilityUses,
        int $attachment,
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
        int $timeAlive,
        string $userID
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->actor = $actor;
        $this->shardId = $shardId;
        $this->abilityUses = $abilityUses;
        $this->attachment = $attachment;
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
        $this->userID = $userID;
    }

    public static function createFromArray(array $participant): self
    {
        Assert::string($participant['type']);
        Assert::string($participant['id']);
        Assert::string($participant['attributes']['actor']);
        Assert::string($participant['attributes']['shardId']);
        Assert::integer($participant['attributes']['stats']['abilityUses']);
        Assert::integer($participant['attributes']['stats']['attachment']);
        Assert::integer($participant['attributes']['stats']['damageDone']);
        Assert::integer($participant['attributes']['stats']['damageReceived']);
        Assert::integer($participant['attributes']['stats']['deaths']);
        Assert::integer($participant['attributes']['stats']['disablesDone']);
        Assert::integer($participant['attributes']['stats']['disablesReceived']);
        Assert::integer($participant['attributes']['stats']['emote']);
        Assert::integer($participant['attributes']['stats']['energyGained']);
        Assert::integer($participant['attributes']['stats']['energyUsed']);
        Assert::integer($participant['attributes']['stats']['healingDone']);
        Assert::integer($participant['attributes']['stats']['healingReceived']);
        Assert::integer($participant['attributes']['stats']['kills']);
        Assert::integer($participant['attributes']['stats']['mount']);
        Assert::integer($participant['attributes']['stats']['outfit']);
        Assert::integer($participant['attributes']['stats']['score']);
        Assert::integer($participant['attributes']['stats']['side']);
        Assert::integer($participant['attributes']['stats']['timeAlive']);

        if (isset($participant['attributes']['stats']['userID'])) {
            $userId = $participant['attributes']['stats']['userID'];
        } else {
            $userId = $participant['relationships']['player']['data']['id'];
        }
        Assert::string($userId);

        return new self(
            $participant['type'],
            $participant['id'],
            $participant['attributes']['actor'],
            $participant['attributes']['shardId'],
            $participant['attributes']['stats']['abilityUses'],
            $participant['attributes']['stats']['attachment'],
            $participant['attributes']['stats']['damageDone'],
            $participant['attributes']['stats']['damageReceived'],
            $participant['attributes']['stats']['deaths'],
            $participant['attributes']['stats']['disablesDone'],
            $participant['attributes']['stats']['disablesReceived'],
            $participant['attributes']['stats']['emote'],
            $participant['attributes']['stats']['energyGained'],
            $participant['attributes']['stats']['energyUsed'],
            $participant['attributes']['stats']['healingDone'],
            $participant['attributes']['stats']['healingReceived'],
            $participant['attributes']['stats']['kills'],
            $participant['attributes']['stats']['mount'],
            $participant['attributes']['stats']['outfit'],
            $participant['attributes']['stats']['score'],
            $participant['attributes']['stats']['side'],
            $participant['attributes']['stats']['timeAlive'],
            $userId
        );
    }
}
