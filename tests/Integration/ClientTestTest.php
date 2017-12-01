<?php
namespace Tests\Integration;

class ClientTestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group integration
     * @test
     */
    public function shouldRetrieveMatchesData()
    {
        $client = new \PtrTn\Battlerite\Client(
            new \GuzzleHttp\Client(),
            getenv('APIKEY')
        );
        $matches = $client->getMatches();
        $this->assertEquals('QUICK2V2', $matches->matches[0]->map->type);
    }
}
