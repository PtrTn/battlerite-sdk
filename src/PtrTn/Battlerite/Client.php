<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Matches;
use PtrTn\Battlerite\Dto\Player;
use PtrTn\Battlerite\Dto\Players;
use PtrTn\Battlerite\Query\MatchesQuery;
use PtrTn\Battlerite\Query\PlayersQuery;

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

    public static function create(string $apiKey): Client
    {
        return new Client(
            new ApiClient(
                $apiKey,
                new GuzzleClient()
            )
        );
    }

    public function getMatches(MatchesQuery $query = null): Matches
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/matches',
            $query
        );
        return Matches::createFromArray($responseData['data']);
    }

    public function getMatch(string $matchId): Match
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/matches/' . $matchId
        );
        return Match::createFromArray($responseData['data']);
    }

    public function getPlayers(PlayersQuery $query = null): Players
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/players',
            $query
        );
        return Players::createFromArray($responseData['data']);
    }

    public function getPlayer(string $playerId): Player
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/players/' . $playerId
        );
        return Player::createFromArray($responseData['data']);
    }
}
