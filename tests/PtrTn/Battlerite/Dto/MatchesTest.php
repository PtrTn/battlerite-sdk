<?php
namespace Tests\PtrTn\Battlerite\Dto;

use PtrTn\Battlerite\Dto\Match;
use PtrTn\Battlerite\Dto\Matches;

class MatchesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateMatchesFromArray()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/matches-response.json');
        $matchesArray = \GuzzleHttp\json_decode($fixture, true);

        $matches = Matches::createFromArray($matchesArray);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(2, $matches->matches);

        foreach ($matches->matches as $match) {
            $this->assertInstanceOf(Match::class, $match);
        }
    }
    /**
     * @test
     */
    public function shouldNotErrorForNoMatches()
    {
        $fixture = file_get_contents(__DIR__ . '/../fixtures/matches-response-empty.json');
        $matchesArray = \GuzzleHttp\json_decode($fixture, true);

        $matches = Matches::createFromArray($matchesArray);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(0, $matches->matches);
    }
}
