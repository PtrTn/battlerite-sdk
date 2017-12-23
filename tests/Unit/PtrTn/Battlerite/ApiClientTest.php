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
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Exception\InvalidResourceException;
use PtrTn\Battlerite\Query\Matches\MatchesQuery;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{
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
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
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
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
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
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
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
                new Request('GET', '/some-endpoint'),
                new Response(500)
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
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
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
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
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/some-endpoint');
    }

    /**
     * @test
     */
    public function shouldSendRequestToEndpoint()
    {
        $expectedMethod = 'GET';
        $expectedScheme = 'https';
        $expectedHost = 'api.dc01.gamelockerapp.com';
        $expectedPath = '/status';

        $historyContainer = [];
        $history = Middleware::history($historyContainer);
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/status-response.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new ApiClient('fake-api-key', $mockClient);
        $apiClient->sendRequestToEndPoint('/status');

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
    public function shouldSendRequestToEndpointWithQuery()
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
                file_get_contents(__DIR__ . '/fixtures/matches/matches-response-84.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $handler->push($history);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new ApiClient('fake-api-key', $mockClient);

        $query = MatchesQuery::create()
            ->withOffset(1)
            ->withLimit(6)
        ;
        $apiClient->sendRequestToEndPoint('/shards/global/matches', $query);

        $this->assertCount(1, $historyContainer);
        /** @var Request $request */
        $request = $historyContainer[0]['request'];
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertEquals($expectedScheme, $request->getUri()->getScheme());
        $this->assertEquals($expectedHost, $request->getUri()->getHost());
        $this->assertEquals($expectedPath, $request->getUri()->getPath());
        $this->assertEquals($expectedQuery, urldecode($request->getUri()->getQuery()));
    }
}
