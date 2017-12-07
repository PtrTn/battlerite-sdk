<?php

namespace PtrTn\Battlerite\Dto\Matches;

use PtrTn\Battlerite\Dto\CollectionDto;
use Webmozart\Assert\Assert;

class Spectators extends CollectionDto
{
    /**
     * @var Spectator[]
     */
    public $items;

    protected function __construct(array $spectators)
    {
        parent::__construct(Spectator::class, $spectators);
    }

    public static function createFromArray(array $spectators): self
    {
        Assert::notNull($spectators);

        $createdSpectators = [];
        foreach ($spectators as $spectator) {
            $createdSpectators[] = Spectator::createFromArray($spectator);
        }
        return new self($createdSpectators);
    }
}

