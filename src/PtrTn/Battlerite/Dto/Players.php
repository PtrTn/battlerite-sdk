<?php

namespace PtrTn\Battlerite\Dto;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;
use Webmozart\Assert\Assert;

class Players implements IteratorAggregate, Countable
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
        Assert::notNull($players);

        $createdPlayers = [];
        foreach ($players as $player) {
            $createdPlayers[] = Player::createFromArray($player);
        }
        return new self($createdPlayers);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->players);
    }

    public function count(): int
    {
        return count($this->players);
    }
}
