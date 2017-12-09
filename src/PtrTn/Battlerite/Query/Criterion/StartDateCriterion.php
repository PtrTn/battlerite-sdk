<?php

namespace PtrTn\Battlerite\Query\Criterion;

use DateTime;
use PtrTn\Battlerite\Exception\InvalidQueryException;

class StartDateCriterion implements CriterionInterface
{
    /**
     * @var DateTime
     */
    private $startDate;

    public function __construct(DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function toArray(): array
    {
        return ['filter[createdAt-start]' => $this->startDate->format(DateTime::ISO8601)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        foreach ($critera as $criterion) {
            if ($criterion instanceof EndDateCriterion) {
                if ($criterion->getValue() < $this->startDate) {
                    throw InvalidQueryException::criteriaCollision('End date must be later than start date');
                }
            }
        }
        return;
    }

    public function getValue(): DateTime
    {
        return $this->startDate;
    }
}
