<?php

namespace PtrTn\Battlerite;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
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

class ClientWithCache
{
    private const CACHE_DIR = '/tmp/battlerite';

    private const CACHE_PREFIX = 'battlerite-';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * @var int
     */
    private $cacheLifetime = 300;

    public function __construct(Client $client, Cache $cache, int $cacheLifetime)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * Create default API client setup with a filesystem caching layer
     */
    public static function create(string $apiKey): self
    {
        return new self(
            new Client(
                new ApiClient(
                    $apiKey,
                    new GuzzleClient()
                )
            ),
            new FilesystemCache(self::CACHE_DIR, '.cache'),
            300
        );
    }

    /**
     * Create default API client setup with a custom caching layer
     */
    public static function createWithCache(string $apiKey, Cache $cache, int $cacheLifetime): self
    {
        return new self(
            new Client(
                new ApiClient(
                    $apiKey,
                    new GuzzleClient()
                )
            ),
            $cache,
            $cacheLifetime
        );
    }

    public function getPlayer(string $playerId): DetailedPlayer
    {
        $cacheKey = self::CACHE_PREFIX . '-player-' . $playerId;
        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }
        $data = $this->client->getPlayer($playerId);
        $this->cache->save($cacheKey, $data, $this->cacheLifetime);
        return $data;
    }

    public function getMatch(string $matchId): DetailedMatch
    {
        $cacheKey = self::CACHE_PREFIX . '-match-' . $matchId;
        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }
        $data = $this->client->getMatch($matchId);
        $this->cache->save($cacheKey, $data, $this->cacheLifetime);
        return $data;
    }

    public function getStatus(): Status
    {
        return $this->client->getStatus();
    }

    public function getMatches(MatchesQuery $query = null): Matches
    {
        return $this->client->getMatches($query);
    }

    public function getPlayers(PlayersQuery $query = null): Players
    {
        return $this->client->getPlayers($query);
    }

    public function getTeams(TeamsQuery $query = null): Teams
    {
        return $this->client->getTeams($query);
    }
}
