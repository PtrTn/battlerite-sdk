<?php

namespace PtrTn\Battlerite\Factory;

use PtrTn\Battlerite\Dto\Player\DetailedPlayer;
use PtrTn\Battlerite\Dto\Player\Stats;
use PtrTn\Battlerite\Repository\DataMappingRepository;
use Webmozart\Assert\Assert;

class DetailedPlayerFactory
{
    /**
     * @var DataMappingRepository
     */
    private $mappingRepository;

    public function __construct(DataMappingRepository $mappingRepository)
    {
        $this->mappingRepository = $mappingRepository;
    }

    public function createFromArray(array $player) : DetailedPlayer
    {
        Assert::string($player['type']);
        Assert::string($player['id']);
        Assert::string($player['attributes']['name']);
        Assert::string($player['attributes']['patchVersion']);
        Assert::string($player['attributes']['shardId']);
        Assert::integer($player['attributes']['stats']['picture']);
        Assert::integer($player['attributes']['stats']['title']);
        Assert::string($player['attributes']['titleId']);

        $stats = $this->createPlayerStats($player['attributes']['stats']);

        return new DetailedPlayer(
            $player['type'],
            $player['id'],
            $player['attributes']['name'],
            $player['attributes']['patchVersion'],
            $player['attributes']['shardId'],
            $player['attributes']['stats']['picture'],
            $player['attributes']['stats']['title'],
            $player['attributes']['titleId'],
            $stats
        );
    }

    private function createPlayerStats(array $stats) : Stats
    {
        $accountStats = [];
        $championStats = [];
        $mapStats = [];
        foreach ($stats as $statKey => $statValue) {
            $mappedStat = $this->mappingRepository->getStatMapping($statKey);

            if ($mappedStat === null) {
                continue;
            }

            if ($mappedStat->isChampionStat()) {
                $championStats[$mappedStat->champion][$mappedStat->statName] = $statValue;
            }
            if ($mappedStat->isMapStat()) {
                $mapStats[$mappedStat->map][$mappedStat->statName] = $statValue;
            }
            $accountStats[$mappedStat->statName] = $statValue;
        }

        $playerStats = Stats::createFromArray($accountStats, $championStats, $mapStats);
        return $playerStats;
    }
}
