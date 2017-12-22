<?php
namespace Tests\Unit\PtrTn\Battlerite\Query\Players;

use PtrTn\Battlerite\Exception\InvalidQueryException;
use PtrTn\Battlerite\Query\Teams\TeamsQuery;

class TeamsQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNullEmptyQuery()
    {
        $query = TeamsQuery::create();
        $this->assertNull($query->toQueryString());
    }

    /**
     * @test
     */
    public function shouldErrorOnMultipleSameCriteria()
    {
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessage(
            'Unable to create query for more than 1 PtrTn\Battlerite\Query\Teams\PlayerIdsCriterion'
        );

        TeamsQuery::create()
            ->forPlayerIds(['1234'])
            ->forPlayerIds(['5789']);
    }

    /**
     * @test
     */
    public function shouldQueryPlayerIds()
    {
        $expectedQuery = 'tag[playerIds]=1234,5789';

        $query = TeamsQuery::create()
            ->forPlayerIds(['1234', '5789']);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }

    /**
     * @test
     */
    public function shouldQueryForSeason()
    {
        $expectedQuery = 'tag[season]=5';

        $query = TeamsQuery::create()
            ->forSeason(5);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }
}
