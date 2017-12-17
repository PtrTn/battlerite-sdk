<?php

namespace PtrTn\Battlerite\Dto\Match;

use Webmozart\Assert\Assert;

class Roster
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
    public $shardId;

    /**
     * @var int
     */
    public $score;

    /**
     * @var bool
     */
    public $won;

    /**
     * @var References
     */
    public $participants;

    private function __construct(
        string $type,
        string $id,
        string $shardId,
        int $score,
        bool $won,
        References $participants
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->shardId = $shardId;
        $this->score = $score;
        $this->won = $won;
        $this->participants = $participants;
    }

    public static function createFromArray(array $roster): self
    {
        Assert::string($roster['type']);
        Assert::string($roster['id']);
        Assert::string($roster['attributes']['shardId']);
        Assert::integer($roster['attributes']['stats']['score']);
        Assert::string($roster['attributes']['won']);

        // Todo, this should probably be a boolean in json.
        $won = $roster['attributes']['won'] ?: filter_var($roster['attributes']['won'], FILTER_VALIDATE_BOOLEAN);

        return new self(
            $roster['type'],
            $roster['id'],
            $roster['attributes']['shardId'] ?? null,
            $roster['attributes']['stats']['score'] ?? null,
            $won,
            References::createFromArray($roster['relationships']['participants']['data'])
        );
    }
}
