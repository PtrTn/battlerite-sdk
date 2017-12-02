<?php

namespace PtrTn\Battlerite\Query;

use Webmozart\Assert\Assert;

class PlayersQuery
{
    /**
     * @var string[]
     */
    private $playerIds;

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function forPlayerIds(array $playerIds)
    {
        Assert::allString($playerIds, 'Specified player ids should be an array of strings');
        $this->playerIds = $playerIds;
        return $this;
    }

    public function toQueryString(): ?string
    {
        $query = [];
        if (!empty($this->playerIds)) {
            $query['filter[playerIds]'] = implode(',', $this->playerIds);
        }

        if (!empty($query)) {
            return http_build_query($query);
        }

        return null;
    }
}
