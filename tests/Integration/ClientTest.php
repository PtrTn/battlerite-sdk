<?php
namespace Tests\Integration;

use PtrTn\Battlerite\Dto\Match;

class ClientTestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group integration
     * @test
     */
    public function shouldRetrieveMatchesData()
    {
        $client = new \PtrTn\Battlerite\Client(
            new \GuzzleHttp\Client(),
            getenv('APIKEY')
        );
        $matches = $client->getMatches();

        $this->assertEquals('QUICK2V2', $matches->matches[0]->map->type);
    }
    /**
     * @group runme
     * @test
     */
    public function shouldRetrieveMatchData()
    {
        $matchId = 'AB9C81FABFD748C8A7EC545AA6AF97CC';
        $client = new \PtrTn\Battlerite\Client(
            new \GuzzleHttp\Client(),
            getenv('APIKEY')
        );
        $match = $client->getMatch($matchId);

        $this->assertInstanceOf(Match::class, $match);
        $this->assertEquals($matchId, $match->id);
    }
}
