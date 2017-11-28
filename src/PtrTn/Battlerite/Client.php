<?php

namespace PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use PtrTn\Battlerite\Dto\Matches;
use PtrTn\Battlerite\Exception\FailedRequestException;
use PtrTn\Battlerite\Exception\InvalidRequestException;
use PtrTn\Battlerite\Factory\MatchesFactory;

class Client
{
    private const BASE_URL = 'https://api.dc01.gamelockerapp.com/shards/global';

    /**
     * @var GuzzleClient
     */
    private $guzzle;
    /**
     * @var string
     */
    private $apiKey;

    public function __construct(GuzzleClient $guzzle, string $apiKey)
    {
        $this->guzzle = $guzzle;
        $this->apiKey = $apiKey;
    }

    public function getMatches(): Matches
    {
        $request = $this->createRequestForEndpoint('/matches');

        $response = $this->sendRequest($request);

        $responseData = $this->getDataFromResponse($response);

        return MatchesFactory::createMatchesFromArray($responseData);
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
            return $this->guzzle->send($request);
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
        if (empty($responseBody)) {
            throw new FailedRequestException('No response');
        }

        try {
            $responseData = \GuzzleHttp\json_decode($responseBody, true);
        } catch (InvalidArgumentException $e) {
            throw FailedRequestException::invalidResponseJson($e);
        }

        if (empty($responseData['data'])) {
            throw new FailedRequestException('No response');
        }

        return $responseData['data'];
    }
}
