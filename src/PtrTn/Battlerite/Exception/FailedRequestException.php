<?php

namespace PtrTn\Battlerite\Exception;

use Exception;
use GuzzleHttp\Exception\ClientException;
use InvalidArgumentException;

class FailedRequestException extends Exception
{
    public static function createForException(ClientException $e): self
    {
        return new self($e->getMessage());
    }

    public static function invalidResponseJson(InvalidArgumentException $e): self
    {
        return new self(sprintf('Response JSON could not be decoded, because "%s"', $e->getMessage()));
    }
}
