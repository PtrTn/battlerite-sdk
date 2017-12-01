<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Spectators
{
    /**
     * @var Spectator[]
     */
    public $spectators;

    private function __construct(array $spectators)
    {
        Assert::allIsInstanceOf($spectators, Spectator::class);

        $this->spectators = $spectators;
    }

    public static function createFromArray(array $spectators): self
    {
        $createdSpectators = [];
        foreach ($spectators as $spectator) {
            $createdSpectators[] = Spectator::createFromArray($spectator);
        }
        return new self($createdSpectators);
    }
}
