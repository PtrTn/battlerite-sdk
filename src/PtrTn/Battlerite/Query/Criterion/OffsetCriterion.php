<?php

namespace PtrTn\Battlerite\Query\Criterion;

class OffsetCriterion implements CriterionInterface
{
    /**
     * @var int
     */
    private $offset;

    public function __construct(int $offset)
    {
        $this->offset = $offset;
    }

    public function toArray(): array
    {
        return ['page[offset]' => $this->offset];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
