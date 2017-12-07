<?php

namespace PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\CollectionDto;
use Webmozart\Assert\Assert;

class Players extends CollectionDto
{
    /**
     * @var Player[]
     */
    public $items;

    public function __construct(array $players)
    {
        parent::__construct(Player::class, $players);
    }

    public static function createFromArray(array $players): self
    {
        Assert::notNull($players);

        $createdPlayers = [];
        foreach ($players as $player) {
            $createdPlayers[] = Player::createFromArray($player);
        }
        return new self($createdPlayers);
    }
}
