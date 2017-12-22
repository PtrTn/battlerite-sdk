<?php

namespace PtrTn\Battlerite\Dto\Teams;

use PtrTn\Battlerite\Assert\Assert;

class Members
{
    /**
     * @var string]
     */
    public $members;

    private function __construct(
        array $members
    ) {
        $this->members = $members;
    }

    public static function createFromArray(array $members): self
    {
        $members = array_map('strval', $members);
        Assert::allString($members);

        return new self($members);
    }
}
