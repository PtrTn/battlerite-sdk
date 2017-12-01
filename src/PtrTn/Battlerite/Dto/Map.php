<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Map
{
    /**
     * @var string
     */
    public $mapId;
    /**
     * @var string
     */
    public $type;

    public function __construct(
        string $mapId,
        string $type
    ) {
        $this->mapId = $mapId;
        $this->type = $type;
    }

    public static function createFromArray(array $stats): self
    {
        Assert::string($stats['mapID']);
        Assert::string($stats['type']);

        return new self(
            $stats['mapID'],
            $stats['type']
        );
    }
}
