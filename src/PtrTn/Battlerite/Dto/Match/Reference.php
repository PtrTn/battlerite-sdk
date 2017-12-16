<?php

namespace PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Assert\Assert;

class Reference
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    private function __construct(
        string $type,
        string $id
    ) {
        $this->type = $type;
        $this->id = $id;
    }

    public static function createFromArray(array $reference): self
    {
        Assert::string($reference['type']);
        Assert::string($reference['id']);

        return new self(
            $reference['type'],
            $reference['id']
        );
    }
}
