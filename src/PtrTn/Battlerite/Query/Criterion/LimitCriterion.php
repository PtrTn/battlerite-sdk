<?php

namespace PtrTn\Battlerite\Query\Criterion;

class LimitCriterion implements CriterionInterface
{
    /**
     * @var int
     */
    private $limit;

    public function __construct(int $offset)
    {
        $this->limit = $offset;
    }

    public function toArray(): array
    {
        return ['page[limit]' => $this->limit];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
