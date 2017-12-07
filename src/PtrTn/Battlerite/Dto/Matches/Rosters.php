<?php

namespace PtrTn\Battlerite\Dto\Matches;

use PtrTn\Battlerite\Dto\CollectionDto;
use Webmozart\Assert\Assert;

class Rosters extends CollectionDto
{
    /**
     * @var Roster[]
     */
    public $items;

    protected function __construct(array $rosters)
    {
        parent::__construct(Roster::class, $rosters);
    }

    public static function createFromArray(array $rosters): self
    {
        Assert::notNull($rosters);

        $createdRosters = [];
        foreach ($rosters as $roster) {
            $createdRosters[] = Roster::createFromArray($roster);
        }
        return new self($createdRosters);
    }
}
