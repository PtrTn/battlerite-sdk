<?php

namespace PtrTn\Battlerite\Dto\Matches;

class Spectator
{

    private function __construct()
    {
    }

    public static function createFromArray(array $spectator): self
    {
        return new self();
    }
}
