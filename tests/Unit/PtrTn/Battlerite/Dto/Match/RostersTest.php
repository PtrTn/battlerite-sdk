<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Match\References;

class RostersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetWinningParticipants()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/match-response.json'), true);
        $match = DetailedMatch::createFromArray($fixture);

        $winningParticipants = $match->rosters->getWinningParticipants();

        $this->assertInstanceOf(References::class, $winningParticipants);

        $this->assertEquals('fcb9ecaf-8976-4c0d-8a23-b80d2155c240', $winningParticipants->items[0]->id);
        $this->assertEquals('d7483fb9-8a52-4767-9cf8-14d9b3732438', $winningParticipants->items[1]->id);
    }
}
