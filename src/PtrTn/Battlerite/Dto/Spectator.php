<?php

namespace PtrTn\Battlerite\Dto;

class Spectator
{

    private function __construct()
    {
    }

    public static function createFromArray(): self
    {
        return new self();
    }
}
