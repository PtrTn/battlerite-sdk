<?php
namespace Tests\Unit\PtrTn\Battlerite\Factory;

use PtrTn\Battlerite\Factory\DetailedPlayerFactory;
use PtrTn\Battlerite\Repository\DataMappingRepository;

class DetailedPlayerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreatePlayerWithStatsFromArray()
    {
        $fixture = \GuzzleHttp\json_decode(
            file_get_contents(__DIR__ . '/../fixtures/player/player-response-84.json'),
            true
        );
        $factory = new DetailedPlayerFactory(new DataMappingRepository());
        $player = $factory->createFromArray($fixture['data']);
        $this->assertEquals('84', $player->id);
        $this->assertEquals(80, $player->stats->accountLevel);
        $this->assertEquals(825, $player->stats->wins);
        $this->assertEquals(379473, $player->stats->ratingMean);
    }
}
