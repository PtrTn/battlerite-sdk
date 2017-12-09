<?php

namespace PtrTn\Battlerite\Query\Criterion;

use Webmozart\Assert\Assert;

class TeamNamesCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    private $teamNames;

    public function __construct(array $teamNames)
    {
        Assert::allString($teamNames, 'Specified team names should be an array of strings');
        $this->teamNames = $teamNames;
    }

    public function toArray(): array
    {
        return ['filter[teamNames]' => implode(',', $this->teamNames)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
