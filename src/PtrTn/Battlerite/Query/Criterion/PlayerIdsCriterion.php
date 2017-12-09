<?php

namespace PtrTn\Battlerite\Query\Criterion;

use Webmozart\Assert\Assert;

class PlayerIdsCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    private $playerIds;

    public function __construct(array $playerIds)
    {
        Assert::allString($playerIds, 'Specified player ids should be an array of strings');
        $this->playerIds = $playerIds;
    }

    public function toArray(): array
    {
        return ['filter[playerIds]' => implode(',', $this->playerIds)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
