<?php
namespace Tests\Integration;

use DateTime;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Players\Players;
use PtrTn\Battlerite\Query\Matches\MatchesQuery;
use PtrTn\Battlerite\Query\Players\PlayersQuery;
use PtrTn\Battlerite\Query\Teams\TeamsQuery;

/**
 * @group integration
 */
class ClientTest extends \PHPUnit_Framework_TestCase
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

        $this->assertEquals('QUICK2V2', $matches[0]->map->type);
    }

    /**
     * @test
     */
    public function shouldRetrieveMatchData()
    {
        $matchId = 'AB9C81FABFD748C8A7EC545AA6AF97CC';
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $match = $client->getMatch($matchId);

        $this->assertInstanceOf(DetailedMatch::class, $match);
        $this->assertCount(3, $match->rounds);
        $this->assertCount(4, $match->participants);
        $this->assertEquals('QUICK2V2', $match->map->type);
        $this->assertEquals($matchId, $match->id);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayerData()
    {
        $playerId = '934791968557563904';
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $player = $client->getPlayer($playerId);

        $this->assertInstanceOf(DetailedPlayer::class, $player);
        $this->assertEquals($playerId, $player->id);
    }

    /**
     * @test
     */
    public function shouldRetrievePlayersData()
    {
        $playerNames = ['PlakkeStrasser', 'Genaan'];
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $players = $client->getPlayers(
            PlayersQuery::create()
            ->forPlayerNames($playerNames)
        );

        $this->assertInstanceOf(Players::class, $players);
        $this->assertEquals('934791968557563904', $players[0]->id);
        $this->assertEquals('934809523846303744', $players[1]->id);
    }

    /**
     * @test
     * @group runme
     */
    public function shouldRetrieveTeamsData()
    {
        $playerIds = ['322'];
        $season = 5;
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $teams = $client->getTeams(
            TeamsQuery::create()
            ->forPlayerIds($playerIds)
            ->forSeason($season)
        );

        $this->assertCount(4, $teams);
        $this->assertEquals(20, $teams[0]->wins);
    }

    /**
     * @test
     */
    public function shouldFilterMatchesForQuery()
    {
        $client = \PtrTn\Battlerite\Client::create(getenv('APIKEY'));
        $endDate = new DateTime('-20 days');
        $matches = $client->getMatches(
            MatchesQuery::create()
                ->withEndDate($endDate)
        );

        $this->assertNotEquals(0, count($matches));
        foreach ($matches as $match) {
            $this->assertLessThanOrEqual($endDate, $match->createdAt);
        }
    }
}
