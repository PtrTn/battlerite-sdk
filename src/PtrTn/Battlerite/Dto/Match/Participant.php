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
     * @var int|null
     */
    public $abilityUses;

    /**
     * @var int
     */
    public $attachment;

    /**
     * @var int|null
     */
    public $damageDone;

    /**
     * @var int|null
     */
    public $damageReceived;

    /**
     * @var int|null
     */
    public $deaths;

    /**
     * @var int|null
     */
    public $disablesDone;

    /**
     * @var int|null
     */
    public $disablesReceived;

    /**
     * @var int
     */
    public $emote;

    /**
     * @var int|null
     */
    public $energyGained;

    /**
     * @var int|null
     */
    public $energyUsed;

    /**
     * @var int|null
     */
    public $healingDone;

    /**
     * @var int|null
     */
    public $healingReceived;

    /**
     * @var int|null
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
     * @var int|null
     */
    public $score;

    /**
     * @var int
     */
    public $side;

    /**
     * @var int|null
     */
    public $timeAlive;

    /**
     * @var string
     */
    public $userID;

    /**
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        string $type,
        string $id,
        string $actor,
        string $shardId,
        ?int $abilityUses,
        int $attachment,
        ?int $damageDone,
        ?int $damageReceived,
        ?int $deaths,
        ?int $disablesDone,
        ?int $disablesReceived,
        int $emote,
        ?int $energyGained,
        ?int $energyUsed,
        ?int $healingDone,
        ?int $healingReceived,
        ?int $kills,
        int $mount,
        int $outfit,
        ?int $score,
        int $side,
        ?int $timeAlive,
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
        $abilityUses = $participant['attributes']['stats']['abilityUses'] ?? null;
        $damageDone = $participant['attributes']['stats']['damageDone'] ?? null;
        $damageReceived = $participant['attributes']['stats']['damageReceived'] ?? null;
        $deaths = $participant['attributes']['stats']['deaths'] ?? null;
        $disablesDone = $participant['attributes']['stats']['disablesDone'] ?? null;
        $disablesReceived = $participant['attributes']['stats']['disablesReceived'] ?? null;
        $energyGained = $participant['attributes']['stats']['energyGained'] ?? null;
        $energyUsed = $participant['attributes']['stats']['energyUsed'] ?? null;
        $healingDone = $participant['attributes']['stats']['healingDone'] ?? null;
        $healingReceived = $participant['attributes']['stats']['healingReceived'] ?? null;
        $kills = $participant['attributes']['stats']['kills'] ?? null;
        $score = $participant['attributes']['stats']['score'] ?? null;
        $timeAlive = $participant['attributes']['stats']['timeAlive'] ?? null;

        Assert::string($participant['type']);
        Assert::string($participant['id']);
        Assert::string($participant['attributes']['actor']);
        Assert::string($participant['attributes']['shardId']);
        Assert::nullOrInteger($abilityUses);
        Assert::integer($participant['attributes']['stats']['attachment']);
        Assert::nullOrInteger($damageDone);
        Assert::nullOrInteger($damageReceived);
        Assert::nullOrInteger($deaths);
        Assert::nullOrInteger($disablesDone);
        Assert::nullOrInteger($disablesReceived);
        Assert::integer($participant['attributes']['stats']['emote']);
        Assert::nullOrInteger($energyGained);
        Assert::nullOrInteger($energyUsed);
        Assert::nullOrInteger($healingDone);
        Assert::nullOrInteger($healingReceived);
        Assert::nullOrInteger($kills);
        Assert::integer($participant['attributes']['stats']['mount']);
        Assert::integer($participant['attributes']['stats']['outfit']);
        Assert::nullOrInteger($score);
        Assert::integer($participant['attributes']['stats']['side']);
        Assert::nullOrInteger($timeAlive);

        if (isset($participant['attributes']['stats']['userID'])) {
            $userId = (string) $participant['attributes']['stats']['userID'];
        } else {
            $userId = (string) $participant['relationships']['player']['data']['id'];
        }
        Assert::string($userId);

        return new self(
            $participant['type'],
            $participant['id'],
            $participant['attributes']['actor'],
            $participant['attributes']['shardId'],
            $abilityUses,
            $participant['attributes']['stats']['attachment'],
            $damageDone,
            $damageReceived,
            $deaths,
            $disablesDone,
            $disablesReceived,
            $participant['attributes']['stats']['emote'],
            $energyGained,
            $energyUsed,
            $healingDone,
            $healingReceived,
            $kills,
            $participant['attributes']['stats']['mount'],
            $participant['attributes']['stats']['outfit'],
            $score,
            $participant['attributes']['stats']['side'],
            $timeAlive,
            $userId
        );
    }
}
