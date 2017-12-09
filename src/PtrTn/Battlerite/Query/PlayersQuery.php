<?php

namespace PtrTn\Battlerite\Query;

use PtrTn\Battlerite\Exception\InvalidQueryException;
use PtrTn\Battlerite\Query\Criterion\CriterionInterface;
use PtrTn\Battlerite\Query\Criterion\PlayerIdsCriterion;

class PlayersQuery implements QueryInterface
{
    /**
     * @var CriterionInterface[]
     */
    private $criteria = [];

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function forPlayerIds(array $playerIds)
    {
        $this->addCriterion(new PlayerIdsCriterion($playerIds));
        return $this;
    }

    public function toQueryString(): ?string
    {
        $query = [];
        foreach ($this->criteria as $criterion) {
            $query = array_merge($query, $criterion->toArray());
        }

        if (!empty($query)) {
            return http_build_query($query);
        }

        return null;
    }

    private function addCriterion(CriterionInterface $criterionToAdd): void
    {
        $criterionToAdd->checkCollisionWithCriteria($this->criteria);
        foreach ($this->criteria as $criterion) {
            if (get_class($criterion) === get_class($criterionToAdd)) {
                throw InvalidQueryException::sameCriteria($criterionToAdd);
            }
        }
        $this->criteria[] = $criterionToAdd;
        return;
    }
}
