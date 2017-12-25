<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Player;

use PtrTn\Battlerite\Dto\Player\DetailedPlayer;

class DetailedPlayerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateFromArray()
    {
        $fixture = file_get_contents(__DIR__ . '/../../fixtures/player/player-response-84.json');
        $fixtureData =  \GuzzleHttp\json_decode($fixture, true);
        $player = DetailedPlayer::createFromArray($fixtureData['data']);
        $this->assertEquals('84', $player->id);
    }
}
