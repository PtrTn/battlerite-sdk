<?php

namespace PtrTn\Battlerite\Dto\Match;

use Webmozart\Assert\Assert;

class Round
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
     * @var int
     */
    public $duration;

    /**
     * @var int
     */
    public $ordinal;

    /**
     * @var int
     */
    public $winningTeam;

    private function __construct(
        string $type,
        string $id,
        int $duration,
        int $ordinal,
        int $winningTeam
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->duration = $duration;
        $this->ordinal = $ordinal;
        $this->winningTeam = $winningTeam;
    }

    public static function createFromArray(array $round): self
    {
        Assert::string($round['type']);
        Assert::string($round['id']);
        Assert::integer($round['attributes']['duration']);
        Assert::integer($round['attributes']['ordinal']);
        Assert::integer($round['attributes']['stats']['winningTeam']);

        return new self(
            $round['type'],
            $round['id'],
            $round['attributes']['duration'],
            $round['attributes']['ordinal'],
            $round['attributes']['stats']['winningTeam']
        );
    }
}
