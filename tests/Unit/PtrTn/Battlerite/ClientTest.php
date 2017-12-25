<?php
namespace Tests\Unit\PtrTn\Battlerite;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use PtrTn\Battlerite\ApiClient;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Matches\Matches;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Players\Players;
use PtrTn\Battlerite\Dto\Status\Status;
use PtrTn\Battlerite\Dto\Teams\Teams;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldCreateWithApiClient()
    {
        $client = Client::create('fake-api-key');

        $this->assertInstanceOf(Client::class, $client);
        $this->assertAttributeInstanceOf(ApiClient::class, 'apiClient', $client);
    }

    /**
     * @test
     */
    public function shouldHandleEmptyResponse()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                file_get_contents(__DIR__ . '/fixtures/matches/matches-response-empty.json')
            )
        ]);
        $handler = HandlerStack::create($mockHandler);
        $mockClient = new GuzzleClient(['handler' => $handler]);
        $apiClient = new Client(new ApiClient('fake-api-key', $mockClient));
        $matches = $apiClient->getMatches();

        $this->assertInstanceOf(Matches::class, $matches);
    }

    /**
     * @test
     */
    public function shouldRetrieveStats()
    {
        $fixtureData = $this->loadFixtureDataFromFile('status-response.json');
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $matches = $client->getStatus();
        $this->assertInstanceOf(Status::class, $matches);
    }

    /**
     * @test
     * @dataProvider getMatchesFixtures
     */
    public function shouldRetrieveMatches(array $fixtureData)
    {
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $matches = $client->getMatches();
        $this->assertInstanceOf(Matches::class, $matches);
    }

    public function getMatchesFixtures()
    {
        return [
            [$this->loadFixtureDataFromFile('matches/matches-response-84.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-4855.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-776588202252308480.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-932292498397777920.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-934763458812112896.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-934808022356762624.json')],
            [$this->loadFixtureDataFromFile('matches/matches-response-935162935435730944.json')],
        ];
    }

    /**
     * @test
     * @dataProvider getDetailedMatchFixtures
     */
    public function shouldRetrieveDetailedMatch(array $fixtureData)
    {
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $match = $client->getMatch('some-match-id');
        $this->assertInstanceOf(DetailedMatch::class, $match);
    }

    public function getDetailedMatchFixtures()
    {
        return [
            [$this->loadFixtureDataFromFile('match/match-response-6B1CD285DB244960A9F1A13E3F4F0FD8.json')],
            [$this->loadFixtureDataFromFile('match/match-response-8C48FE62140248D89DF5E3F334933EBD.json')],
            [$this->loadFixtureDataFromFile('match/match-response-35CB35CF4399427EA7B934C0990ED0CC.json')],
            [$this->loadFixtureDataFromFile('match/match-response-70D9343E561743A4AF058CF6AD324B24.json')],
            [$this->loadFixtureDataFromFile('match/match-response-668ADC78F91F4C2D97D8CBC3657408E6.json')],
            [$this->loadFixtureDataFromFile('match/match-response-1560C4251DC340BD9027163A616DE1F3.json')],
            [$this->loadFixtureDataFromFile('match/match-response-AB9C81FABFD748C8A7EC545AA6AF97CC.json')],
        ];
    }

    /**
     * @test
     * @dataProvider getPlayersFixtures
     */
    public function shouldRetrievePlayers(array $fixtureData)
    {
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $match = $client->getPlayers();
        $this->assertInstanceOf(Players::class, $match);
    }

    public function getPlayersFixtures()
    {
        return [
            [$this->loadFixtureDataFromFile('players/players-response-Exblack.json')],
            [$this->loadFixtureDataFromFile('players/players-response-NeedforGreed.json')],
            [$this->loadFixtureDataFromFile('players/players-response-PlakkeStrasser-Genaan.json')],
            [$this->loadFixtureDataFromFile('players/players-response-Skywind-Cannotbestolen.json')],
            [$this->loadFixtureDataFromFile('players/players-response-Wicked..json')],
        ];
    }

    /**
     * @test
     * @dataProvider getTeamsFixtures
     */
    public function shouldRetrieveTeams(array $fixtureData)
    {
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $match = $client->getTeams();
        $this->assertInstanceOf(Teams::class, $match);
    }

    public function getTeamsFixtures()
    {
        return [
            [$this->loadFixtureDataFromFile('teams/teams-response-84-s3.json')],
            [$this->loadFixtureDataFromFile('teams/teams-response-84-s5.json')],
            [$this->loadFixtureDataFromFile('teams/teams-response-322-s5.json')],
            [$this->loadFixtureDataFromFile('teams/teams-response-1436-1801-s5.json')],
            [$this->loadFixtureDataFromFile('teams/teams-response-1436-s5.json')],
            [$this->loadFixtureDataFromFile('teams/teams-response-4855-s5.json')],
        ];
    }

    /**
     * @test
     * @dataProvider getDetailedPlayerFixtures
     */
    public function shouldRetrieveDetailedPlayer(array $fixtureData)
    {
        $apiClientMock = Mockery::mock(ApiClient::class);
        $apiClientMock
            ->shouldReceive('sendRequestToEndPoint')
            ->andReturn($fixtureData)
            ->once();

        $client = new Client($apiClientMock);
        $player = $client->getPlayer('some-player-id');
        $this->assertInstanceOf(DetailedPlayer::class, $player);
    }

    public function getDetailedPlayerFixtures()
    {
        return [
            [$this->loadFixtureDataFromFile('player\player-response-84.json')],
            [$this->loadFixtureDataFromFile('player\player-response-4855.json')],
            [$this->loadFixtureDataFromFile('player\player-response-776588202252308480.json')],
            [$this->loadFixtureDataFromFile('player\player-response-932292498397777920.json')],
            [$this->loadFixtureDataFromFile('player\player-response-934763458812112896.json')],
            [$this->loadFixtureDataFromFile('player\player-response-934791968557563904.json')],
            [$this->loadFixtureDataFromFile('player\player-response-934808022356762624.json')],
            [$this->loadFixtureDataFromFile('player\player-response-935162935435730944.json')],
        ];
    }

    private function loadFixtureDataFromFile($filePath): array
    {
        $fixture = file_get_contents(__DIR__ . '/fixtures/' . $filePath);
        return \GuzzleHttp\json_decode($fixture, true);
    }
}
