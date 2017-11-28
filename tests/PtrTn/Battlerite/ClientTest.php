<?php
namespace Tests\PtrTn\Battlerite;

use PtrTn\Battlerite\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $client = new Client();
        $this->assertTrue(true);
    }
}
