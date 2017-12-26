<?php

namespace PtrTn\Battlerite\Dto\Player;

class Map
{
    /**
     * @var string
     */
    public $name;

    public $wins;

    public $losses;

    private function __construct()
    {
    }

    public static function createFromArray(string $mapName, array $mapStats): self
    {
        $map = new self();
        $map->name = $mapName;
        $map->wins = $mapStats['MapWins'] ?? null;
        $map->losses = $mapStats['MapLosses'] ?? null;

        return $map;
    }
}
