<?php
namespace Tests\Unit\PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Matches;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Query\MatchesQuery;

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
        $apiClient = new Client($mockClient, 'fake-api-key');
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
        $apiClient = new Client($mockClient, 'fake-api-key');

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
        $apiClient = new Client($mockClient, 'fake-api-key');
        $apiClient->getMatch('some-match-id');

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
    public function shouldConvertResponseToMatches()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/matches-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client($mockClient, 'fake-api-key');
        $matches = $apiClient->getMatches();

        $this->assertInstanceOf(Matches::class, $matches);
    }

    /**
     * @test
     */
    public function shouldConvertResponseToMatch()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/match-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client($mockClient, 'fake-api-key');
        $match = $apiClient->getMatch('some-match-id');

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals(331, $match->duration);
        $this->assertEquals('1733162751', $match->gameMode);
        $this->assertEquals('1.0', $match->patchVersion);
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
        $apiClient = new Client($mockClient, 'fake-api-key');
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
        $apiClient = new Client($mockClient, 'fake-api-key');
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
        $apiClient = new Client($mockClient, 'fake-api-key');
        $apiClient->getMatches();
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
        $apiClient = new Client($mockClient, 'fake-api-key');
        $apiClient->getMatches();
    }

    public function shouldHandleNoResponse()
    {
        $this->expectException(FailedRequestException::class);
        $this->expectExceptionMessage('No response');

        $mockHandler = new MockHandler([
            new Response(200)
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client($mockClient, 'fake-api-key');
        $apiClient->getMatches();
    }
}
