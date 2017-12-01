<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Rosters
{
    /**
     * @var Roster[]
     */
    public $rosters;

    private function __construct(array $rosters)
    {
        Assert::allIsInstanceOf($rosters, Roster::class);

        $this->rosters = $rosters;
    }

    public static function createFromArray(array $rosters): self
    {
        $createdRosters = [];
        foreach ($rosters as $roster) {
            $createdRosters[] = Roster::createFromArray($roster);
        }
        return new self($createdRosters);
    }
}
