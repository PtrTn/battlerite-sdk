<?php
namespace Tests\Unit\PtrTn\Battlerite;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Mockery;
use Mockery\Mock;
use PtrTn\Battlerite\Client;
use PtrTn\Battlerite\ClientWithCache;
use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Matches\Matches;
use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Players\Players;
use PtrTn\Battlerite\Dto\Status\Status;
use PtrTn\Battlerite\Dto\Teams\Teams;

class ClientWithCacheTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client|Mock
     */
    private $client;

    /**
     * @var ClientWithCache
     */
    private $clientWithCache;

    public function setUp()
    {
        $this->client = Mockery::mock(Client::class);

        $cache = new ArrayCache();
        $this->clientWithCache = new ClientWithCache($this->client, $cache, 300);
    }

    /**
     * @test
     */
    public function shouldCreateClientWithDefaultCache()
    {
        $client = ClientWithCache::create('fake-api-key');

        $this->assertInstanceOf(ClientWithCache::class, $client);
        $this->assertAttributeInstanceOf(Client::class, 'client', $client);
        $this->assertAttributeInstanceOf(FilesystemCache::class, 'cache', $client);
    }

    /**
     * @test
     */
    public function shouldCreateClientWithCustomCache()
    {
        $client = ClientWithCache::createWithCache(
            'fake-api-key',
            new ArrayCache(),
            300
        );

        $this->assertInstanceOf(ClientWithCache::class, $client);
        $this->assertAttributeInstanceOf(Client::class, 'client', $client);
        $this->assertAttributeInstanceOf(ArrayCache::class, 'cache', $client);
    }

    /**
     * @test
     */
    public function shouldRetrieveMatchFromCacheIfAvailable()
    {
        $this->client
            ->shouldReceive('getMatch')
            ->andReturn(Mockery::mock(DetailedMatch::class));

        $this->clientWithCache->getMatch('12345');
        $this->clientWithCache->getMatch('12345');

        $this->client->shouldHaveReceived('getMatch')->once();

        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldRetrievePlayerFromCacheIfAvailable()
    {
        $this->client
            ->shouldReceive('getPlayer')
            ->andReturn(Mockery::mock(DetailedPlayer::class));

        $this->clientWithCache->getPlayer('12345');
        $this->clientWithCache->getPlayer('12345');

        $this->client->shouldHaveReceived('getPlayer')->once();

        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldNotCacheStatus()
    {
        $this->client
            ->shouldReceive('getStatus')
            ->andReturn(Mockery::mock(Status::class));

        $this->clientWithCache->getStatus();
        $this->clientWithCache->getStatus();

        $this->client->shouldHaveReceived('getStatus')->twice();

        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldNotCachePlayers()
    {
        $this->client
            ->shouldReceive('getPlayers')
            ->andReturn(Mockery::mock(Players::class));

        $this->clientWithCache->getPlayers();
        $this->clientWithCache->getPlayers();

        $this->client->shouldHaveReceived('getPlayers')->twice();

        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldNotCacheMatches()
    {
        $this->client
            ->shouldReceive('getMatches')
            ->andReturn(Mockery::mock(Matches::class));

        $this->clientWithCache->getMatches();
        $this->clientWithCache->getMatches();

        $this->client->shouldHaveReceived('getMatches')->twice();

        Mockery::close();
    }

    /**
     * @test
     */
    public function shouldNotCacheTeams()
    {
        $this->client
            ->shouldReceive('getTeams')
            ->andReturn(Mockery::mock(Teams::class));

        $this->clientWithCache->getTeams();
        $this->clientWithCache->getTeams();

        $this->client->shouldHaveReceived('getTeams')->twice();

        Mockery::close();
    }
}
