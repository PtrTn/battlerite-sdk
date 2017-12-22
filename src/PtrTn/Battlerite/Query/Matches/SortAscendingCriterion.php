<?php

namespace PtrTn\Battlerite\Query\Matches;

use PtrTn\Battlerite\Query\CriterionInterface;

class SortAscendingCriterion implements CriterionInterface
{
    /**
     * @var string
     */
    private $sortField;

    public function __construct(string $sortField)
    {
        $this->sortField = $sortField;
    }

    public function toArray(): array
    {
        return ['sort' => $this->sortField];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
