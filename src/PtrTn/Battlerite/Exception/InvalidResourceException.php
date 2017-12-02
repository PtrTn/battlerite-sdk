<?php

namespace PtrTn\Battlerite\Exception;

use Exception;

class InvalidResourceException extends Exception
{
    public static function resourceNotFound()
    {
        return new self('Requested resource not found');
    }
}
