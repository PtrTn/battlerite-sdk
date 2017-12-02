<?php

namespace PtrTn\Battlerite\Query;

use DateTime;
use Webmozart\Assert\Assert;

class MatchesQuery
{
    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var string|null
     */
    private $sortBy;

    /**
     * @var DateTime|null
     */
    private $startDate;

    /**
     * @var DateTime|null
     */
    private $endDate;

    /**
     * @var string[]
     */
    private $playerIds;

    /**
     * @var string[]
     */
    private $teamNames;

    /**
     * @var string[]
     */
    private $gameModes;

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function withOffset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function sortBy(string $sortBy): self
    {
        $this->sortBy = $sortBy;
        return $this;
    }

    public function withStartDate(DateTime $startDate)
    {
        if (isset($this->endDate)) {
            Assert::greaterThan($this->endDate, $startDate, 'End date must be later than start date');
        }

        $this->startDate = $startDate;
        return $this;
    }

    public function withEndDate(DateTime $endDate)
    {
        if (isset($this->startDate)) {
            Assert::greaterThan($endDate, $this->startDate, 'End date must be later than start date');
        }

        $this->endDate = $endDate;
        return $this;
    }

    public function forPlayerIds(array $playerIds)
    {
        Assert::allString($playerIds, 'Specified player ids should be an array of strings');
        $this->playerIds = $playerIds;
        return $this;
    }

    public function forTeamNames(array $teamNames)
    {
        Assert::allString($teamNames, 'Specified team names should be an array of strings');
        $this->teamNames = $teamNames;
        return $this;
    }

    public function forGameModes(array $gameModes)
    {
        Assert::allString($gameModes, 'Specified game modes should be an array of strings');
        $this->gameModes = $gameModes;
        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function toQueryString(): ?string
    {
        $query = [];
        if (isset($this->offset)) {
            $query['page[offset]'] = $this->offset;
        }
        if (isset($this->limit)) {
            $query['page[limit]'] = $this->limit;
        }
        if (isset($this->sortBy)) {
            $query['sort'] = $this->sortBy;
        }
        if (isset($this->startDate)) {
            $query['filter[createdAt-start]'] = $this->startDate->format(DateTime::ISO8601);
        }
        if (isset($this->endDate)) {
            $query['filter[createdAt-end]'] = $this->endDate->format(DateTime::ISO8601);
        }
        if (!empty($this->playerIds)) {
            $query['filter[playerIds]'] = implode(',', $this->playerIds);
        }
        if (!empty($this->teamNames)) {
            $query['filter[teamNames]'] = implode(',', $this->teamNames);
        }
        if (!empty($this->gameModes)) {
            $query['filter[gameMode]'] = implode(',', $this->gameModes);
        }

        if (!empty($query)) {
            return http_build_query($query);
        }

        return null;
    }
}
