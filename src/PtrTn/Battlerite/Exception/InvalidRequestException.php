<?php

namespace PtrTn\Battlerite\Exception;

use Exception;

class InvalidRequestException extends Exception
{
    public static function invalidApiKey(): self
    {
        return new self('Invalid Api key');
    }

    public static function rateLimitReached(): self
    {
        return new self('Rate limit reached');
    }
}
