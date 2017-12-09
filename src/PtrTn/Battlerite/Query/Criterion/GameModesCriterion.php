<?php

namespace PtrTn\Battlerite\Query\Criterion;

use Webmozart\Assert\Assert;

class GameModesCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    private $gameModes;

    public function __construct(array $gameModes)
    {
        Assert::allString($gameModes, 'Specified game modes should be an array of strings');
        $this->gameModes = $gameModes;
    }

    public function toArray(): array
    {
        return ['filter[gameMode]' => implode(',', $this->gameModes)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
