<?php

namespace PtrTn\Battlerite\Dto;

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
     * @var string|null
     */
    public $stats;

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
        ?string $stats,
        string $titleId
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->stats = $stats;
        $this->titleId = $titleId;
    }

    public static function createFromArray(array $match): self
    {
        Assert::string($match['type']);
        Assert::string($match['id']);
        Assert::string($match['attributes']['name']);
        Assert::string($match['attributes']['patchVersion']);
        Assert::string($match['attributes']['shardId']);
        Assert::nullOrString($match['attributes']['stats']);
        Assert::string($match['attributes']['titleId']);

        return new self(
            $match['type'],
            $match['id'],
            $match['attributes']['name'],
            $match['attributes']['patchVersion'],
            $match['attributes']['shardId'],
            $match['attributes']['stats'],
            $match['attributes']['titleId']
        );
    }
}
