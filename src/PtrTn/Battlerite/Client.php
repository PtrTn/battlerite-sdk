<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use PtrTn\Battlerite\Dto\Matches;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;

class Client
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

    public function getMatches(): Matches
    {
        $request = $this->createRequestForEndpoint('/matches');

        $response = $this->sendRequest($request);

        $responseData = $this->getDataFromResponse($response);

        return Matches::createFromArray($responseData);
    }

    private function createRequestForEndpoint(string $endpoint): Request
    {
        return new Request(
            'GET',
            self::BASE_URL . $endpoint,
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
                throw InvalidRequestException::invalidApiKey();
            }
            if ($e->getResponse()->getStatusCode() === 429) {
                throw InvalidRequestException::rateLimitReached();
            }

            throw FailedRequestException::createForException($e);
        }
    }

    private function getDataFromResponse(ResponseInterface $response): array
    {
        $responseBody = $response->getBody()->getContents();
        if (!isset($responseBody)) {
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
