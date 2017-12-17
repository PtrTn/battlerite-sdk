<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Players;

use PtrTn\Battlerite\Dto\Players\Players;

class PlayersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetPlayerByShard()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/players-response.json'), true);
        $players = Players::createFromArray($fixture['data']);

        $player = $players->getPlayerByNameAndShard('PlakkeStrasser', 'global');
        $this->assertNotNull($player);
        $this->assertEquals('PlakkeStrasser', $player->name);
    }
}
