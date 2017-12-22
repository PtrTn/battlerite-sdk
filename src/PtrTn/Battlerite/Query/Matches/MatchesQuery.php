<?php

namespace PtrTn\Battlerite\Query\Matches;

use DateTime;
use PtrTn\Battlerite\Exception\InvalidQueryException;
use PtrTn\Battlerite\Query\CriterionInterface;
use PtrTn\Battlerite\Query\QueryInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MatchesQuery implements QueryInterface
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

    public function withOffset(int $offset): self
    {
        $this->addCriterion(new OffsetCriterion($offset));
        return $this;
    }

    public function withLimit(int $limit): self
    {
        $this->addCriterion(new LimitCriterion($limit));
        return $this;
    }

    public function sortBy(string $sortBy): self
    {
        $this->addCriterion(new SortAscendingCriterion($sortBy));
        return $this;
    }

    public function sortDescBy(string $sortBy): self
    {
        $this->addCriterion(new SortDescendingCriterion($sortBy));
        return $this;
    }

    public function withStartDate(DateTime $startDate)
    {
        $this->addCriterion(new StartDateCriterion($startDate));
        return $this;
    }

    public function withEndDate(DateTime $endDate)
    {
        $this->addCriterion(new EndDateCriterion($endDate));
        return $this;
    }

    public function forPlayerIds(array $playerIds)
    {
        $this->addCriterion(new PlayerIdsCriterion($playerIds));
        return $this;
    }

    public function forTeamNames(array $teamNames)
    {
        $this->addCriterion(new TeamNamesCriterion($teamNames));
        return $this;
    }

    public function forGameModes(array $gameModes)
    {
        $this->addCriterion(new GameModesCriterion($gameModes));
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
