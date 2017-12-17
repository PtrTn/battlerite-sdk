<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\Match\DetailedMatch;

class RostersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetWinningRoster()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/match-response.json'), true);
        $match = DetailedMatch::createFromArray($fixture);
        $winningRoster = $match->rosters->getWinningRoster();
        $this->assertEquals('08cd7762-73d2-44d5-af14-549fe14448f1', $winningRoster->id);
    }

    /**
     * @test
     */
    public function shouldGetWinningParticipants()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/match-response.json'), true);
        $match = DetailedMatch::createFromArray($fixture);

        $winningParticipant = $match->getParticipantByPlayerId('786059759278252032');
        $losingParticipant = $match->getParticipantByPlayerId('783082365810540544');

        $this->assertFalse($match->rosters->hasParticipantWon($losingParticipant));
        $this->assertTrue($match->rosters->hasParticipantWon($winningParticipant));
    }
}
