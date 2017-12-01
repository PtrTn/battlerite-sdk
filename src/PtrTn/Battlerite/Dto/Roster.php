<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Roster
{
    /**
     * @var string
     */
    public $type;
    /**
     * @var string
     */
    public $id;

    private function __construct(
        string $type,
        string $id
    ) {
        $this->type = $type;
        $this->id = $id;
    }

    public static function createFromArray(array $roster): self
    {
        Assert::string($roster['type']);
        Assert::string($roster['id']);

        return new self(
            $roster['type'],
            $roster['id']
        );
    }
}
