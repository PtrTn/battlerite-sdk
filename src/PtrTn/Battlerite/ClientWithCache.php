<?php

namespace PtrTn\Battlerite;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client as GuzzleClient;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;

class ClientWithCache
{
    private const CACHE_DIR = '/tmp/battlerite';

    private const CACHE_PREFIX = 'battlerite-';

    private const CACHE_LIFETIME = 300;

    /**
     * @var Client
     */
    private $client;
    /**
     * @var Cache
     */
    private $cache;

    public function __construct(Client $client, Cache $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
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
            ),
            new FilesystemCache(self::CACHE_DIR, '.cache')
        );
    }

    public function getPlayer(string $playerId): DetailedPlayer
    {
        $cacheKey = self::CACHE_PREFIX . '-player-' . $playerId;
        if ($this->cache->contains($cacheKey)) {
            return $this->cache->fetch($cacheKey);
        }
        $data = $this->client->getPlayer($playerId);
        $this->cache->save($cacheKey, $data, self::CACHE_LIFETIME);
        return $data;
    }
}
