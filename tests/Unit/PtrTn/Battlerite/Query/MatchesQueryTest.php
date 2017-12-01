<?php
namespace Tests\Unit\PtrTn\Battlerite\Query;

use DateTime;
use InvalidArgumentException;
use PtrTn\Battlerite\Query\MatchesQuery;

class MatchesQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNullEmptyQuery()
    {
        $query = MatchesQuery::create();
        $this->assertNull($query->toQueryString());
    }

    /**
     * @test
     */
    public function shouldQueryLimit()
    {
        $expectedQuery = 'page[limit]=6';
        
        $query = MatchesQuery::create();
        $query->withLimit(6);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldAllowChaining()
    {
        $expectedQuery = 'page[offset]=5&page[limit]=6';

        $query = MatchesQuery::create();
        $query->withLimit(6);
        $query->withOffset(5);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldFormatDate()
    {
        $expectedQuery = 'filter[createdAt-end]=1991-10-26T12:24:00+01:00';

        $query = MatchesQuery::create()
            ->withEndDate(new DateTime('26-10-1991 12:24'));
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldNotAllowStartDateAfterEndDate()
    {
        $this->expectExceptionMessage(InvalidArgumentException::class);
        $this->expectExceptionMessage('End date must be later than start date');

        MatchesQuery::create()
            ->withEndDate(new DateTime('-5 days'))
            ->withStartDate(new DateTime('-3 days'));
    }

    /**
     * @test
     */
    public function shouldNotAllowEndDateBeforeStartDate()
    {
        $this->expectExceptionMessage(InvalidArgumentException::class);
        $this->expectExceptionMessage('End date must be later than start date');

        MatchesQuery::create()
            ->withStartDate(new DateTime('-3 days'))
            ->withEndDate(new DateTime('-5 days'));
    }
}
