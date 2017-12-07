<?php

namespace PtrTn\Battlerite\Dto\Match;

use Webmozart\Assert\Assert;

class Asset
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

    public static function createFromArray(array $asset): self
    {
        Assert::string($asset['type']);
        Assert::string($asset['id']);

        return new self(
            $asset['type'],
            $asset['id']
        );
    }
}
