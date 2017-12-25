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
        $fixture = \GuzzleHttp\json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/matches/matches-response-932292498397777920.json'),
            true
        );

        $matches = Matches::createFromArray($fixture['data']);

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
        $fixture = \GuzzleHttp\json_decode(
            file_get_contents(__DIR__ . '/../../fixtures/matches/matches-response-empty.json'),
            true
        );

        $matches = Matches::createFromArray($fixture['data']);

        $this->assertInstanceOf(Matches::class, $matches);
        $this->assertCount(0, $matches);
    }
}
