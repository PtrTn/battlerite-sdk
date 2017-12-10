<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Matches\Matches;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Players\Players;
use PtrTn\Battlerite\Dto\Status\Status;
use PtrTn\Battlerite\Query\MatchesQuery;
use PtrTn\Battlerite\Query\PlayersQuery;

class ClientWithCache
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create default API client setup with a caching layer
     */
    public static function create(string $apiKey): self
    {
        return new self(
            new Client(
                new ApiClient(
                    $apiKey,
                    new GuzzleClient()
                )
            )
        );
    }

    public function getStatus(): Status
    {
        return $this->client->getStatus();
    }

    public function getMatches(MatchesQuery $query = null): Matches
    {
        return $this->client->getMatches($query);
    }

    public function getMatch(string $matchId): DetailedMatch
    {
        return $this->client->getMatch($matchId);
    }

    public function getPlayers(PlayersQuery $query = null): Players
    {
        return $this->client->getPlayers($query);
    }

    public function getPlayer(string $playerId): DetailedPlayer
    {
        return $this->client->getPlayer($playerId);
    }
}
