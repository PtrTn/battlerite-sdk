<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\Match\DetailedMatch;

class DetailedMatchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldGetParticipantByPlayerId()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/match-response.json'), true);
        $match = DetailedMatch::createFromArray($fixture);
        $participant = $match->getParticipantByPlayerId('786059759278252032');
        $this->assertEquals('fcb9ecaf-8976-4c0d-8a23-b80d2155c240', $participant->id);
    }

    /**
     * @test
     */
    public function shouldCheckIfPlayerHasWon()
    {
        $fixture = json_decode(file_get_contents(__DIR__ . '/../../fixtures/match-response.json'), true);
        $match = DetailedMatch::createFromArray($fixture);

        $this->assertFalse($match->hasPlayerWon('783082365810540544'));
        $this->assertTrue($match->hasPlayerWon('786059759278252032'));
    }
}
