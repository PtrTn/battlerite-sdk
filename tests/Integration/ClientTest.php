<?php
namespace Tests\Integration;

use DateTime;
use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Player;
use PtrTn\Battlerite\Query\MatchesQuery;

/**
 * @group integration
 */
class ClientTestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldRetriveApiStatus()
    {
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $status = $client->getStatus();

        $this->assertEquals('gamelocker', $status->id);
    }
    /**
     * @test
     */
    public function shouldRetrieveMatchesData()
    {
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $matches = $client->getMatches();

        $this->assertEquals('QUICK2V2', $matches->matches[0]->map->type);
    }

    /**
     * @test
     */
    public function shouldRetrieveMatchData()
    {
        $matchId = 'AB9C81FABFD748C8A7EC545AA6AF97CC';
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $match = $client->getMatch($matchId);

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($matchId, $match->id);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayerData()
    {
        $this->markTestSkipped('Endpoint is not yet implemented');

        $playerId = '931405258914193408';
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $match = $client->getPlayer($playerId);

        $this->assertInstanceOf(Player::class, $match);
        $this->assertEquals($playerId, $match->id);
    }

    /**
     * @test
     */
    public function shouldFilterMatchesForQuery()
    {
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $matches = $client->getMatches(
            MatchesQuery::create()
            ->withEndDate(new DateTime('-20 days'))
        );

        $this->assertNotEquals(0, count($matches->matches));
        foreach ($matches->matches as $match) {
            $this->assertTrue(new DateTime('-20 days') < $match->createdAt);
        }
    }
}
