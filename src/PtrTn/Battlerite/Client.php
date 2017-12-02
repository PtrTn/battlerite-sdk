<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
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

    private function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public static function create(string $apiKey, ?ClientInterface $httpClient = null): Client
    {
        return new Client(
            new ApiClient(
                $httpClient ?? new GuzzleClient(),
                $apiKey
            )
        );
    }

    public function getMatches(MatchesQuery $query = null): Matches
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/matches',
            $query
        );
        return Matches::createFromArray($responseData);
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
        return Players::createFromArray($responseData);
    }

    public function getPlayer(string $playerId): Player
    {
        $responseData = $this->apiClient->sendRequestToEndPoint(
            '/players/' . $playerId
        );
        return Player::createFromArray($responseData['data']);
    }
}
