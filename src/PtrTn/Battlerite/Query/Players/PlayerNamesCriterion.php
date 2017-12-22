<?php

namespace PtrTn\Battlerite\Query\Players;

use PtrTn\Battlerite\Query\CriterionInterface;
use Webmozart\Assert\Assert;

class PlayerNamesCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    private $playerNames;

    public function __construct(array $playerNames)
    {
        Assert::allString($playerNames, 'Specified player names should be an array of strings');
        $this->playerNames = $playerNames;
    }

    public function toArray(): array
    {
        return ['filter[playerNames]' => implode(',', $this->playerNames)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
