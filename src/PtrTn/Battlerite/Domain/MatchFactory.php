<?php

namespace BattleRite\Domain;

use PtrTn\Battlerite\Dto\Match\DetailedMatch as MatchDto;
use PtrTn\Battlerite\Dto\Match\Participant as ParticipantDto;
use PtrTn\Battlerite\Dto\Match\Roster as RosterDto;

class MatchFactory
{
    public static function createFromMatchDto(MatchDto $matchDto): Match
    {
        return new Match(
            $matchDto->id,
            $matchDto->createdAt,
            $matchDto->duration,
            $matchDto->map->type,
            self::createTeams($matchDto),
            self::createRounds($matchDto)
        );
    }

    private static function createTeams(MatchDto $matchDto): Teams
    {
        $teams = [];
        /** @var RosterDto $roster */
        foreach ($matchDto->rosters as $roster) {
            $players = [];
            /** @var ParticipantDto $participant */
            foreach ($roster->participants as $participant) {
                $players[] = new Player(
                    $participant->id,
                    $participant->actor,
                    $participant->abilityUses,
                    $participant->damageDone,
                    $participant->damageReceived,
                    $participant->deaths,
                    $participant->disablesDone,
                    $participant->disablesReceived,
                    $participant->emote,
                    $participant->energyGained,
                    $participant->energyUsed,
                    $participant->healingDone,
                    $participant->healingReceived,
                    $participant->kills,
                    $participant->mount,
                    $participant->outfit,
                    $participant->score,
                    $participant->side,
                    $participant->timeAlive
                );
            }
            $teams = new Team(
                new Players($players),
                $roster->won
            );
        }
        return new Teams($teams);
    }

    private static function createRounds(MatchDto $matchDto): Rounds
    {
        $rounds = [];
        foreach ($matchDto->rounds as $round) {
            $rounds[] = new Round(
                $round->duration,
                $round->winningTeam
            );
        }
        return new Rounds($rounds);
    }
}
