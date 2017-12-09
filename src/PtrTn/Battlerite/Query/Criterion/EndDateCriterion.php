<?php

namespace PtrTn\Battlerite\Query\Criterion;

use DateTime;
use PtrTn\Battlerite\Exception\InvalidQueryException;

class EndDateCriterion implements CriterionInterface
{
    /**
     * @var DateTime
     */
    private $endDate;

    public function __construct(DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    public function toArray(): array
    {
        return ['filter[createdAt-end]' => $this->endDate->format(DateTime::ISO8601)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        foreach ($critera as $criterion) {
            if ($criterion instanceof StartDateCriterion) {
                if ($this->endDate < $criterion->getValue()) {
                    throw InvalidQueryException::criteriaCollision('End date must be later than start date');
                }
            }
        }
        return;
    }

    public function getValue(): DateTime
    {
        return $this->endDate;
    }
}
