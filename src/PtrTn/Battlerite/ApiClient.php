<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Exception\InvalidResourceException;
use PtrTn\Battlerite\Query\QueryInterface;

class ApiClient
{
    private const BASE_URL = 'https://api.dc01.gamelockerapp.com/shards/global';

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(ClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    public function sendRequestToEndPoint(string $endpoint, ?QueryInterface $query = null)
    {
        $request = $this->createRequestForEndpoint(
            $endpoint,
            $query ? $query->toQueryString() : null
        );
        $response = $this->sendRequest($request);

        return $this->getDataFromResponse($response);
    }

    private function createRequestForEndpoint(string $endpoint, string $query = null): Request
    {
        $uri = self::BASE_URL . $endpoint;
        if (isset($query)) {
            $uri .= '?' . $query;
        }

        return new Request(
            'GET',
            $uri,
            [
                'Accept' => 'application/json',
                'Authorization' => $this->apiKey
            ]
        );
    }

    private function sendRequest($request): ResponseInterface
    {
        try {
            return $this->httpClient->send($request);
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                throw InvalidRequestException::invalidApiKey($this->apiKey);
            }
            if ($e->getResponse()->getStatusCode() === 429) {
                throw InvalidRequestException::rateLimitReached();
            }
            if ($e->getResponse()->getStatusCode() === 404) {
                throw InvalidResourceException::resourceNotFound();
            }

            throw FailedRequestException::createForException($e);
        }
    }

    private function getDataFromResponse(ResponseInterface $response): array
    {
        $responseBody = $response->getBody()->getContents();
        if (!isset($responseBody) || $responseBody === '') {
            throw new FailedRequestException('No response');
        }

        try {
            $responseData = \GuzzleHttp\json_decode($responseBody, true);
        } catch (InvalidArgumentException $e) {
            throw FailedRequestException::invalidResponseJson($e);
        }

        return $responseData;
    }
}