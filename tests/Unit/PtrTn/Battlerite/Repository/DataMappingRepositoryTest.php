<?php
namespace Tests\Unit\PtrTn\Battlerite\Repository;

use PtrTn\Battlerite\Repository\DataMappingRepository;

class DataMappingRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataMappingRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new DataMappingRepository();
    }

    /**
     * @test
     */
    public function shouldGetStatMapping()
    {
        $this->assertEquals('Wins', $this->repository->getStatMapping('2')->statName);
        $this->assertEquals('Ranked2v2Wins', $this->repository->getStatMapping('10')->statName);
        $this->assertEquals('AccountLevel', $this->repository->getStatMapping('26')->statName);
        $this->assertEquals('RatingMean', $this->repository->getStatMapping('70')->statName);
    }

    /**
     * @test
     */
    public function shouldReturnNullIfStatNotFound()
    {
        $this->assertNull($this->repository->getStatMapping('-5'));
    }

    /**
     * @test
     */
    public function shouldGetChampionStatMapping()
    {
        $stat = $this->repository->getStatMapping('11001');
        $this->assertTrue($stat->isChampionStat());
        $this->assertEquals('Alchemist', $stat->champion);
    }
}
