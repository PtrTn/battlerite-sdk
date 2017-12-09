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
     * @var null|string
     */
    private $shardId;

    /**
     * @var int|null
     */
    private $score;

    /**
     * @var bool|null
     */
    private $won;

    /**
     * @var null|Participants
     */
    private $participants;

    private function __construct(
        string $type,
        string $id,
        ?string $shardId,
        ?int $score,
        ?bool $won,
        ?Participants $participants
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
        if (isset($roster['attributes'])) {
            Assert::nullOrString($roster['attributes']['shardId']);
            Assert::nullOrInteger($roster['attributes']['stats']['score']);
            Assert::nullOrString($roster['attributes']['won']);
        }

        // Todo, this should probably be a boolean in json.
        $won = $roster['attributes']['won'] ? filter_var($roster['attributes']['won'], FILTER_VALIDATE_BOOLEAN) : null;

        return new self(
            $roster['type'],
            $roster['id'],
            $roster['attributes']['shardId'] ?? null,
            $roster['attributes']['stats']['score'] ?? null,
            $won,
            null
        );
    }
}
