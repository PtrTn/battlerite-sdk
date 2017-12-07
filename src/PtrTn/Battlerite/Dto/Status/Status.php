<?php

namespace PtrTn\Battlerite\Dto\Status;

use DateTime;
use PtrTn\Battlerite\Assert\Assert;

class Status
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $id;

    /**
     * @var DateTime
     */
    public $releasedAt;

    /**
     * @var string
     */
    public $version;

    public function __construct(
        string $type,
        string $id,
        DateTime $releasedAt,
        string $version
    ) {
        $this->type = $type;
        $this->type = $type;
        $this->id = $id;
        $this->releasedAt = $releasedAt;
        $this->version = $version;
    }

    public static function createFromArray($status): self
    {
        Assert::string($status['type']);
        Assert::string($status['id']);
        Assert::date($status['attributes']['releasedAt'], DateTime::ISO8601);
        Assert::string($status['attributes']['version']);

        return new self(
            $status['type'],
            $status['id'],
            DateTime::createFromFormat(DateTime::ISO8601, $status['attributes']['releasedAt']),
            $status['attributes']['version']
        );
    }
}
