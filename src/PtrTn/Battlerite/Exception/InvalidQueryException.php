<?php

namespace PtrTn\Battlerite\Exception;

use Exception;
use PtrTn\Battlerite\Query\Criterion\CriterionInterface;

class InvalidQueryException extends Exception
{
    public static function sameCriteria(CriterionInterface $criterion)
    {
        return new self(sprintf('Unable to create query for more than 1 %s', get_class($criterion)));
    }

    public static function criteriaCollision(string $error)
    {
        return new self(sprintf('Unable to create query, because %s', $error));
    }
}
