<?php

namespace Tests\Feature\Public;

use GuzzleHttp\Client as Guzzle;
use NeedLaravelSite\TikApi\Client\HttpClient;
use NeedLaravelSite\TikApi\TikApi;
use PHPUnit\Framework\TestCase;

class FollowersIntegrationTest extends TestCase
{
    protected TikApi $tikapi;

    protected function setUp(): void
    {
        parent::setUp();

        $apiKey = $_ENV['TIKAPI_API_KEY'] ?? null;

        if (!$apiKey) {
            $this->markTestSkipped('No TIKAPI_API_KEY set in .env for integration test.');
        }

        $http = new HttpClient(new Guzzle(), $apiKey);
        $this->tikapi = new TikApi($apiKey);
    }

    public function testPublicFollowersEndpointReturnsSuccess()
    {
        $secUid = 'MS4wLjABAAAAsHntXC3s0AvxcecggxsoVa4eAiT8OVafVZ4OQXxy-9htpnUi0sOYSr0kGGD1Loud';

        $response = $this->tikapi->public()->followers()->list($secUid, 5);

        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', strtolower($response['status']));
        $this->assertArrayHasKey('userList', $response);
    }
}
