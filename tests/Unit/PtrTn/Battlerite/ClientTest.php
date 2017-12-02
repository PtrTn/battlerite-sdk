<?php
namespace Tests\Unit\PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PtrTn\Battlerite\ApiClient;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Matches;
use PtrTn\Battlerite\Dto\Player;
use PtrTn\Battlerite\Dto\Players;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Exception\InvalidResourceException;
use PtrTn\Battlerite\Query\MatchesQuery;
use PtrTn\Battlerite\Query\PlayersQuery;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetrieveMatches()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/matches';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/matches-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
    }

    /**
     * @test
     */
    public function shouldRetrieveMatchesForQuery()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/matches';
        $expectedQuery = 'page[offset]=1&page[limit]=6';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/matches-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));

        $query = MatchesQuery::create()
            ->withOffset(1)
            ->withLimit(6)
        ;
        $apiClient->getMatches($query);

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertEquals($expectedQuery, urldecode($request->getUri()->getQuery()));
    }

    /**
     * @test
     */
    public function shouldRetrieveMatch()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/matches/some-match-id';
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
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $match = $apiClient->getMatch('some-match-id');

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($expectedMatchId, $match->id);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayers()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/players';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/players-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $players = $apiClient->getPlayers();

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertInstanceOf(Players::class, $players);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayersForQuery()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/players';
        $expectedQuery = 'filter[playerIds]=1234,5678';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/players-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));

        $query = PlayersQuery::create()
            ->forPlayerIds([
                '1234',
                '5678'
            ])
        ;
        $apiClient->getPlayers($query);

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertEquals($expectedQuery, urldecode($request->getUri()->getQuery()));
    }

    /**
     * @test
     */
    public function shouldRetrievePlayer()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/shards/global/players/some-player-id';
        $expectedPlayerName = 'Peter';

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
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $player = $apiClient->getPlayer('some-player-id');

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals($expectedPlayerName, $player->name);
    }

    /**
     * @test
     */
    public function shouldHandleEmptyResponse()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/matches-response-empty.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $matches = $apiClient->getMatches();

        $this->assertInstanceOf(Matches::class, $matches);
    }

    /**
     * @test
     */
    public function shouldHandleRateLimit()
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Rate limit reached');

        $mockHandler = new MockHandler([
            new Response(429)
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();
    }

    /**
     * @test
     */
    public function shouldHandleInvalidApiKey()
    {
        $this->expectException(InvalidRequestException::class);
        $this->expectExceptionMessage('Invalid Api key');

        $mockHandler = new MockHandler([
            new Response(401)
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();
    }

    /**
     * @test
     */
    public function shouldHandleResourceNotFound()
    {
        $this->expectException(InvalidResourceException::class);
        $this->expectExceptionMessage('Requested resource not found');

        $mockHandler = new MockHandler([
            new Response(404)
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatch('invalid-match-id');
    }

    /**
     * @test
     */
    public function shouldHandleUnknownResponse()
    {
        $this->expectException(FailedRequestException::class);
        $this->expectExceptionMessage('Server error');

        $mockHandler = new MockHandler([
            new ClientException(
                'Server error',
                new Request('GET', '/matches'),
                new Response(500)
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();
    }

    /**
     * @test
     */
    public function shouldHandleNoResponse()
    {
        $this->expectException(FailedRequestException::class);
        $this->expectExceptionMessage('No response');

        $mockHandler = new MockHandler([
            new Response(200)
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();
    }

    /**
     * @test
     */
    public function shouldHandleInvalidJsonResponse()
    {
        $this->expectException(FailedRequestException::class);
        $this->expectExceptionMessage('Response JSON could not be decoded');

        $mockHandler = new MockHandler([
            new Response(200, [], 'some-invalid-json')
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $apiClient->getMatches();
    }
}
