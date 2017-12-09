<?php

namespace PtrTn\Battlerite\Query\Criterion;

class SortDescendingCriterion implements CriterionInterface
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
        return ['sort' => '-' . $this->sortField];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
