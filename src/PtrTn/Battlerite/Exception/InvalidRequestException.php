<?php

namespace PtrTn\Battlerite\Exception;

use Exception;

class InvalidRequestException extends Exception
{
    public static function invalidApiKey(string $apiKey): self
    {
        return new self(sprintf('Invalid Api key "%s"', $apiKey));
    }

    public static function rateLimitReached(): self
    {
        return new self('Rate limit reached');
    }
}
