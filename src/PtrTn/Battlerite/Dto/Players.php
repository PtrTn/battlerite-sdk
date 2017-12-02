<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Players
{
    /**
     * @var Player[]
     */
    public $players;

    private function __construct(array $players)
    {
        Assert::allIsInstanceOf($players, Player::class);

        $this->players = $players;
    }

    public static function createFromArray(array $players): self
    {
        Assert::notNull($players['data']);

        $createdPlayers = [];
        foreach ($players['data'] as $player) {
            $createdPlayers[] = Player::createFromArray($player);
        }
        return new self($createdPlayers);
    }
}
