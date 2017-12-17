<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Match;

use PtrTn\Battlerite\Dto\Match\Participants;

class ParticipantsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateFromArray()
    {
        $participant = json_decode(
            '{
              "type": "participant",
              "id": "075d9016-4b8f-4056-81c2-5cd1750c600c",
              "attributes": {
                "actor": "1422481252",
                "shardId": "global",
                "stats": {
                  "abilityUses": 83,
                  "attachment": 2076111428,
                  "damageDone": 877,
                  "damageReceived": 837,
                  "deaths": 2,
                  "disablesDone": 109,
                  "disablesReceived": 135,
                  "emote": 2041147308,
                  "energyGained": 485,
                  "energyUsed": 375,
                  "healingDone": 163,
                  "healingReceived": 159,
                  "kills": 2,
                  "mount": 2089656107,
                  "outfit": 807625209,
                  "score": 1149,
                  "side": 1,
                  "timeAlive": 132,
                  "userID": "785877916079755264"
                }
              },
              "relationships": {
                "player": {
                  "data": {
                    "type": "player",
                    "id": "785877916079755264"
                  }
                }
              }
            }',
            true
        );
        $participants = [
           $participant,
           $participant,
        ];
        $participants = Participants::createFromArray($participants);
        $this->assertCount(2, $participants);
        $this->assertEquals('075d9016-4b8f-4056-81c2-5cd1750c600c', $participants[0]->id);
    }
}
