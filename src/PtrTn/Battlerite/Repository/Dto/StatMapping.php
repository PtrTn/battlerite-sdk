<?php

namespace PtrTn\Battlerite\Repository\Dto;

class StatMapping
{
    /**
     * @var string
     */
    public $statName;

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
        $this->statName = $name;
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
        return $this->statName === 'XP';
    }

    public function isLevel(): bool
    {
        return $this->statName === 'Level';
    }
}
