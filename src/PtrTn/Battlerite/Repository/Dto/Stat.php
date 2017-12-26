<?php

namespace PtrTn\Battlerite\Repository\Dto;

class Stat
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var null|string
     */
    public $champion;

    /**
     * @var null|string
     */
    private $map;

    public function __construct(string $name, ?string $champion, ?string $map)
    {
        $this->name = $name;
        $this->champion = $champion;
        $this->map = $map;
    }

    public static function createFromArray(array $statData): self
    {
        return new self(
            $statData['stat'],
            $statData['champion'] ?? null,
            $statData['map'] ?? null
        );
    }

    public function isXp(): bool
    {
        return $this->name === 'XP';
    }

    public function isLevel(): bool
    {
        return $this->name === 'Level';
    }
}
