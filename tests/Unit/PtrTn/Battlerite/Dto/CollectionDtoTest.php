<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto;

use PtrTn\Battlerite\Dto\Match\Reference;
use PtrTn\Battlerite\Dto\Match\References;

class CollectionDtoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var References
     */
    private $collectionDto;

    public function setUp()
    {
        $this->collectionDto = References::createFromArray([
            [
                'type' => 'some-type',
                'id'   => 'some-id'
            ],
            [
                'type' => 'some-type-2',
                'id'   => 'some-id-2'
            ],
        ]);
    }

    /**
     * @test
     */
    public function shouldCountItems()
    {
        $this->assertCount(2, $this->collectionDto);
    }

    /**
     * @test
     */
    public function shouldHaveArrayAccess()
    {
        $this->assertEquals('some-id', $this->collectionDto[0]->id);
        $this->assertEquals('some-id-2', $this->collectionDto[1]->id);
    }

    /**
     * @test
     */
    public function shouldSetArrayValues()
    {
        $this->collectionDto[2] = Reference::createFromArray([
            'type' => 'some-type-3',
            'id' => 'some-id-3'
        ]);
        $this->assertCount(3, $this->collectionDto);
        $this->assertEquals('some-id-3', $this->collectionDto[2]->id);
    }

    /**
     * @test
     */
    public function shouldUnsetArrayValues()
    {
        unset($this->collectionDto[1]);
        $this->assertCount(1, $this->collectionDto);
    }

    /**
     * @test
     */
    public function shouldCheckIfValueIsset()
    {
        $this->assertTrue(isset($this->collectionDto[1]));
        $this->assertFalse(isset($this->collectionDto[5]));
    }
}
