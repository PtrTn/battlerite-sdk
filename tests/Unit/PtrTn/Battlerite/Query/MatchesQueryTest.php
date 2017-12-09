<?php
namespace Tests\Unit\PtrTn\Battlerite\Query;

use DateTime;
use PtrTn\Battlerite\Exception\InvalidQueryException;
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

        $query = MatchesQuery::create()
            ->withLimit(6);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldSortDescending()
    {
        $expectedQuery = 'sort=-duration';

        $query = MatchesQuery::create()
            ->sortDescBy('duration');
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldAllowChaining()
    {
        $expectedQuery =
            'page[offset]=5' .
            '&page[limit]=6' .
            '&sort=duration' .
            '&filter[createdAt-start]=2017-11-18T10:33:43+0100' .
            '&filter[createdAt-end]=2017-11-25T10:33:43+0100' .
            '&filter[playerIds]=1234,5789' .
            '&filter[teamNames]=Destruction,Derby' .
            '&filter[gameMode]=casual,ranked';

        $query = MatchesQuery::create()
            ->withOffset(5)
            ->withLimit(6)
            ->sortBy('duration')
            ->withStartDate(new DateTime('2017-11-18T10:33:43+0100'))
            ->withEndDate(new DateTime('2017-11-25T10:33:43+0100'))
            ->forPlayerIds(['1234', '5789'])
            ->forTeamNames(['Destruction', 'Derby'])
            ->forGameModes(['casual,ranked']);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldNotAllowStartDateAfterEndDate()
    {
        $this->expectException(InvalidQueryException::class);
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
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessage('End date must be later than start date');

        MatchesQuery::create()
            ->withStartDate(new DateTime('-3 days'))
            ->withEndDate(new DateTime('-5 days'));
    }

    /**
     * @test
     */
    public function shouldErrorOnMultipleSameCriteria()
    {
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessage(
            'Unable to create query for more than 1 PtrTn\Battlerite\Query\Criterion\PlayerIdsCriterion'
        );

        MatchesQuery::create()
            ->forPlayerIds(['1234'])
            ->forPlayerIds(['5789']);
    }
}
