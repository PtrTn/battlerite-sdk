<?php
namespace Tests\Unit\PtrTn\Battlerite\Assert;

use DateTime;
use InvalidArgumentException;
use PtrTn\Battlerite\Assert\Assert;

class AssertTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldValidateDate()
    {
        Assert::date('2017-11-22T20:52:47Z', DateTime::ISO8601);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionOnInvalidDate()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a valid date');

        Assert::date('14-10-2011', DateTime::ISO8601);
    }
}
