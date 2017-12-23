<?php
namespace Tests\Unit\PtrTn\Battlerite\Dto\Matches;

use PtrTn\Battlerite\Dto\Matches\Match;
use PtrTn\Battlerite\Dto\Matches\Matches;

/**
 * @requires PHP 7.2
 */
class MatchesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateMatchesFromArray()
    {
        $fixture = json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/match/match-response-AB9C81FABFD748C8A7EC545AA6AF97CC.json'),
            true
        );
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
        $fixture = json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/match/match-response-AB9C81FABFD748C8A7EC545AA6AF97CC.json'),
            true
        );
        $matchesArray = \GuzzleHttp\json_decode($fixture, true);

        $matches = Matches::createFromArray($matchesArray['data']);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(0, $matches);
    }
}
