<?php

namespace PtrTn\Battlerite\Dto\Players;

use ArrayIterator;
use PtrTn\Battlerite\Dto\CollectionDto;
use Traversable;
use Webmozart\Assert\Assert;

class Players extends CollectionDto
{
    /**
     * @var Player[]
     */
    public $items;

    protected function __construct(array $players)
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

    /**
     * @return Traversable|Player[]
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function getPlayerByShard(string $shard) : ?Player
    {
        foreach ($this->items as $player) {
            if ($player->shardId === $shard) {
                return $player;
            }
        }
        return null;
    }
}
