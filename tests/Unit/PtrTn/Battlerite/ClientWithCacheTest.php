<?php
namespace Tests\Unit\PtrTn\Battlerite;

use Doctrine\Common\Cache\ArrayCache;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PtrTn\Battlerite\ApiClient;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\ClientWithCache;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;

class ClientWithCacheTest extends \PHPUnit_Framework_TestCase
{
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
        $apiClient = new ClientWithCache(
            new Client(
                new ApiClient('fake-api-key', $mockClient)
            ),
            new ArrayCache()
        );
        $player = $apiClient->getPlayer('same-player-id');
        $playerFromCache = $apiClient->getPlayer('same-player-id');

        $this->assertCount(1, $historyContainer);
        $this->assertInstanceOf(DetailedPlayer::class, $player);
        $this->assertEquals($expectedPlayerName, $player->name);
        $this->assertEquals($expectedPlayerName, $playerFromCache->name);
    }
}
