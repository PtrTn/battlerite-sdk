<?php

namespace PtrTn\Battlerite\Assert;

use DateTime;
use Webmozart\Assert\Assert as BaseAssert;

class Assert extends BaseAssert
{
    public static function date($value, $format, $message = '')
    {
        $date = DateTime::createFromFormat($format, $value);
        if ($date === false) {
            static::reportInvalidArgument(sprintf(
                $message ?: 'Expected a valid date in format %s. Got: %s',
                $format,
                $value
            ));
        }
    }
}
