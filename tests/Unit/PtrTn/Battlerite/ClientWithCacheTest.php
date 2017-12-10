<?php
namespace Tests\Unit\PtrTn\Battlerite;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PtrTn\Battlerite\ApiClient;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\ClientWithCache;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;

class ClientWithCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateClientWithDefaultCache()
    {
        $client = ClientWithCache::create('fake-api-key');

        $this->assertInstanceOf(ClientWithCache::class, $client);
        $this->assertAttributeInstanceOf(Client::class, 'client', $client);
        $this->assertAttributeInstanceOf(FilesystemCache::class, 'cache', $client);
    }

    /**
     * @test
     */
    public function shouldCreateClientWithCustomCache()
    {
        $client = ClientWithCache::createWithCache(
            'fake-api-key',
            new ArrayCache(),
            300
        );

        $this->assertInstanceOf(ClientWithCache::class, $client);
        $this->assertAttributeInstanceOf(Client::class, 'client', $client);
        $this->assertAttributeInstanceOf(ArrayCache::class, 'cache', $client);
    }

    /**
     * @test
     */
    public function shouldRetrieveMatch()
    {
        $expectedMatchId = 'AB9C81FABFD748C8A7EC545AA6AF97CC';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/match-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = $this->createClientForHttpClient($mockClient);
        $match = $apiClient->getMatch('some-match-id');
        $matchFromCache = $apiClient->getMatch('some-match-id');

        $this->assertCount(1, $historyContainer);
        $this->assertInstanceOf(DetailedMatch::class, $match);
        $this->assertEquals($expectedMatchId, $match->id);
        $this->assertEquals($expectedMatchId, $matchFromCache->id);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayer()
    {
        $expectedPlayerName = 'PlakkeStrasser';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/player-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = $this->createClientForHttpClient($mockClient);
        $player = $apiClient->getPlayer('same-player-id');
        $playerFromCache = $apiClient->getPlayer('same-player-id');

        $this->assertCount(1, $historyContainer);
        $this->assertInstanceOf(DetailedPlayer::class, $player);
        $this->assertEquals($expectedPlayerName, $player->name);
        $this->assertEquals($expectedPlayerName, $playerFromCache->name);
    }

    private function createClientForHttpClient(ClientInterface $mockClient):ClientWithCache
    {
        $apiClient = new ClientWithCache(
            new Client(
                new ApiClient('fake-api-key', $mockClient)
            ),
            new ArrayCache(),
            300
        );
        return $apiClient;
    }
}
