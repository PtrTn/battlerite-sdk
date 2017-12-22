<?php

namespace PtrTn\Battlerite\Query\Teams;

use PtrTn\Battlerite\Query\CriterionInterface;

class SeasonCriterion implements CriterionInterface
{
    /**
     * @var int
     */
    private $season;

    public function __construct(int $season)
    {
        $this->season = $season;
    }

    public function toArray(): array
    {
        return ['tag[season]' => $this->season];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
