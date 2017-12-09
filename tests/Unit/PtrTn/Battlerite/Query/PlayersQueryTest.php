<?php
namespace Tests\Unit\PtrTn\Battlerite\Query;

use PtrTn\Battlerite\Exception\InvalidQueryException;
use PtrTn\Battlerite\Query\PlayersQuery;

class PlayersQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldNullEmptyQuery()
    {
        $query = PlayersQuery::create();
        $this->assertNull($query->toQueryString());
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

        PlayersQuery::create()
            ->forPlayerIds(['1234'])
            ->forPlayerIds(['5789']);
    }

    /**
     * @test
     */
    public function shouldQueryPlayerIds()
    {
        $expectedQuery = 'filter[playerIds]=1234,5789';

        $query = PlayersQuery::create()
            ->forPlayerIds(['1234', '5789']);
        $this->assertEquals($expectedQuery, urldecode($query->toQueryString()));
    }
}
