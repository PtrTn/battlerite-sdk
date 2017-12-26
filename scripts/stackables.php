<?php

$stackablesJsonFile = 'https://raw.githubusercontent.com/gamelocker/battlerite-assets/master/mappings/39644/stackables.json';

$contents = file_get_contents($stackablesJsonFile);
$stackables = json_decode($contents, true);

$stackablesMapping = [];
foreach ($stackables['Mappings'] as $stackable) {
    if (isset($stackable['StackableId'], $stackable['StackableRangeName'], $stackable['DevName'])) {
        $statName = $stackable['StackableRangeName'];
        $statId = $stackable['StackableId'];

        switch ($statName) {
            case 'XP':
            case 'CharacterWins':
            case 'CharacterLosses':
            case 'CharacterKills':
            case 'CharacterDeaths':
            case 'CharacterTimePlayed':
            case 'CharacterRanked2v2Wins':
            case 'CharacterRanked2v2Losses':
            case 'CharacterRanked3v3Wins':
            case 'CharacterRanked3v3Losses':
            case 'CharacterUnranked2v2Wins':
            case 'CharacterUnranked2v2Losses':
            case 'CharacterUnranked3v3Wins':
            case 'CharacterUnranked3v3Losses':
            case 'CharacterBrawlWins':
            case 'CharacterBrawlLosses':
            case 'CharacterBattlegroundsWins':
            case 'CharacterBattlegroundsLosses':
            case 'Level':
                $championDevname = $stackable['DevName'];
                $stackablesMapping[$statId] = ['stat' => $statName, 'champion' => $championDevname];
                break;
            case 'MapWins':
            case 'MapLosses':
                $mapName = $stackable['DevName'];
                $stackablesMapping[$statId] = ['stat' => $statName, 'map' => $mapName];
                break;
            case 'Attachments':
            case 'Mount':
            case 'Characters':
            case 'VictoryPoses':
            case 'Outfits':
                break;
            default:
                $stackablesMapping[$statId] = ['stat' => $statName];
                break;
        }
    }
}

ksort($stackablesMapping);

file_put_contents('statsMapping.json', json_encode($stackablesMapping));
