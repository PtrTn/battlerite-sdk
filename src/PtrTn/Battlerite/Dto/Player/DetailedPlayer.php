<?php

namespace PtrTn\Battlerite\Dto\Player;

class DetailedPlayer
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
     * @var int
     */
    public $picture;

    /**
     * @var int
     */
    public $title;

    /**
     * @var string
     */
    public $titleId;

    /**
     * @var Stats
     */
    public $stats;

    public function __construct(
        string $type,
        string $id,
        string $name,
        string $patchVersion,
        string $shardId,
        int $picture,
        int $title,
        string $titleId,
        Stats $stats
    ) {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->patchVersion = $patchVersion;
        $this->shardId = $shardId;
        $this->picture = $picture;
        $this->title = $title;
        $this->titleId = $titleId;
        $this->stats = $stats;
    }
}
