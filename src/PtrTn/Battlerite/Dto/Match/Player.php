<?php

namespace PtrTn\Battlerite\Dto\Match;

use Webmozart\Assert\Assert;

class Player
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
    public $name;

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

    private function __construct(
        string $type,
        string $id,
        string $name,
        string $patchVersion,
        string $shardId,
        string $titleId
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->titleId = $titleId;
    }

    public static function createFromArray(array $player): self
    {
        Assert::string($player['type']);
        Assert::string($player['id']);
        Assert::string($player['attributes']['name']);
        Assert::string($player['attributes']['patchVersion']);
        Assert::string($player['attributes']['shardId']);
        Assert::string($player['attributes']['titleId']);

        return new self(
            $player['type'],
            $player['id'],
            $player['attributes']['name'],
            $player['attributes']['patchVersion'],
            $player['attributes']['shardId'],
            $player['attributes']['titleId']
        );
    }
}
