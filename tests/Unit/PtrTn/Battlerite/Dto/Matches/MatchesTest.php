<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Matches;

use PtrTn\Battlerite\Dto\Matches\Match;
use PtrTn\Battlerite\Dto\Matches\Matches;

class MatchesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateMatchesFromArray()
    {
        $fixture = file_get_contents(__DIR__ . '/../../fixtures/matches-response.json');
        $matchesArray = \GuzzleHttp\json_decode($fixture, true);

        $matches = Matches::createFromArray($matchesArray['data']);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(5, $matches);

        foreach ($matches as $match) {
            $this->assertInstanceOf(Match::class, $match);
        }
    }
    /**
     * @test
     */
    public function shouldNotErrorForNoMatches()
    {
        $fixture = file_get_contents(__DIR__ . '/../../fixtures/matches-response-empty.json');
        $matchesArray = \GuzzleHttp\json_decode($fixture, true);

        $matches = Matches::createFromArray($matchesArray['data']);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(0, $matches);
    }
}
