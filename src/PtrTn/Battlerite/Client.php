<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Matches\Matches;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Players\Players;
use PtrTn\Battlerite\Dto\Status\Status;
use PtrTn\Battlerite\Dto\Teams\Teams;
use PtrTn\Battlerite\Query\Matches\MatchesQuery;
use PtrTn\Battlerite\Query\Players\PlayersQuery;
use PtrTn\Battlerite\Query\Teams\TeamsQuery;

class Client
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Create default API client setup
     */
    public static function create(string $apiKey): self
    {
        return new self(
            new ApiClient(
                $apiKey,
                new GuzzleClient()
            )
        );
    }

    public function getStatus(): Status
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/status'
        );
        return Status::createFromArray($responseData['data']);
    }

    public function getMatches(MatchesQuery $query = null): Matches
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/shards/global/matches',
            $query
        );
        return Matches::createFromArray($responseData['data']);
    }

    public function getMatch(string $matchId): DetailedMatch
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/shards/global/matches/' . $matchId
        );
        return DetailedMatch::createFromArray($responseData);
    }

    public function getPlayers(PlayersQuery $query = null): Players
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/shards/global/players',
            $query
        );
        return Players::createFromArray($responseData['data']);
    }

    public function getPlayer(string $playerId): DetailedPlayer
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/shards/global/players/' . $playerId
        );
        return DetailedPlayer::createFromArray($responseData['data']);
    }

    public function getTeams(TeamsQuery $query = null): Teams
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/shards/global/teams',
            $query
        );
        return Teams::createFromArray($responseData['data']);
    }
}
