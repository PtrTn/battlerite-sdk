<?php

namespace PtrTn\Battlerite\Dto;

use Webmozart\Assert\Assert;

class Round
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

    public static function createFromArray(array $round): self
    {
        Assert::string($round['type']);
        Assert::string($round['id']);

        return new self(
            $round['type'],
            $round['id']
        );
    }
}
