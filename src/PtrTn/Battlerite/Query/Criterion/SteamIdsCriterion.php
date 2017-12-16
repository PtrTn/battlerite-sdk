<?php

namespace PtrTn\Battlerite\Query\Criterion;

use Webmozart\Assert\Assert;

class SteamIdsCriterion implements CriterionInterface
{
    /**
     * @var array
     */
    private $steamIds;

    public function __construct(array $steamIds)
    {
        Assert::allString($steamIds, 'Specified steam ids should be an array of strings');
        $this->steamIds = $steamIds;
    }

    public function toArray(): array
    {
        return ['filter[steamIds]' => implode(',', $this->steamIds)];
    }

    public function checkCollisionWithCriteria(array $critera): void
    {
        return;
    }
}
