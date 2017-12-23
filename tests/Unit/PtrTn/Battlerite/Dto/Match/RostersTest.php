<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\Match\DetailedMatch;
use PtrTn\Battlerite\Dto\Match\Roster;

class RostersTest extends \PHPUnit_Framework_TestCase
{
    public function shouldCreateFromArray()
    {
        $roster = json_decode(
            '{
                "type": "roster",
                "id": "eb7710c3-1647-41af-bef7-716171f43ae1",
                "attributes": {
                "shardId": "global",
                "stats": {
                  "score": 0
                },
                "won": "false"
                },
                "relationships": {
                "participants": {
                  "data": [
                    {
                      "type": "participant",
                      "id": "7560e24d-24ce-463e-b4a9-951b99a8128f"
                    },
                    {
                      "type": "participant",
                      "id": "075d9016-4b8f-4056-81c2-5cd1750c600c"
                    }
                  ]
                },
                "team": {
                  "data": null
                }
                }
            }'
        );
        $roster = Roster::createFromArray($roster);
        $this->assertEquals('eb7710c3-1647-41af-bef7-716171f43ae1', $roster->id);
        $this->assertCount(2, $roster->participants);
    }

    /**
     * @test
     */
    public function shouldGetWinningRoster()
    {
        $fixture = json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/match/match-response-AB9C81FABFD748C8A7EC545AA6AF97CC.json'),
            true
        );
        $match = DetailedMatch::createFromArray($fixture);
        $winningRoster = $match->rosters->getWinningRoster();
        $this->assertEquals('08cd7762-73d2-44d5-af14-549fe14448f1', $winningRoster->id);
    }

    /**
     * @test
     */
    public function shouldGetWinningParticipants()
    {
        $fixture = json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/match/match-response-AB9C81FABFD748C8A7EC545AA6AF97CC.json'),
            true
        );
        $match = DetailedMatch::createFromArray($fixture);

        $winningParticipant = $match->getParticipantByPlayerId('786059759278252032');
        $losingParticipant = $match->getParticipantByPlayerId('783082365810540544');

        $this->assertFalse($match->rosters->hasParticipantWon($losingParticipant));
        $this->assertTrue($match->rosters->hasParticipantWon($winningParticipant));
    }
}
