<?php

namespace PtrTn\Battlerite\Repository;

use PtrTn\Battlerite\Repository\Dto\Stat;

class DataMappingRepository
{
    /**
     * @var array|null
     */
    private $mapping;

    public function getStatMapping($statKey): ?Stat
    {
        $this->lazyLoadData();

        if (!isset($this->mapping[$statKey])) {
            return null;
        }

        return Stat::createFromArray($this->mapping[$statKey]);
    }

    private function lazyLoadData(): void
    {
        if (!isset($this->mapping)) {
            $mappingJson = __DIR__ . '/../../../../data/statsMapping.json';
            $this->mapping = \GuzzleHttp\json_decode(file_get_contents($mappingJson), true);
        }
        return;
    }
}
