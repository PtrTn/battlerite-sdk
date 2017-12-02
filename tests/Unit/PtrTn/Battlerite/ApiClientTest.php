<?php
namespace Tests\Unit\PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PtrTn\Battlerite\ApiClient;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Exception\InvalidResourceException;

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
}
