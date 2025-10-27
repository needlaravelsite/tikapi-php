<?php

namespace Tests\Feature\Public;

use NeedLaravelSite\TikApi\TikApi;
use PHPUnit\Framework\TestCase;

class CheckIntegrationTest extends TestCase
{
    protected TikApi $tikapi;

    protected function setUp(): void
    {
        parent::setUp();

        $apiKey = $_ENV['TIKAPI_API_KEY'] ?? null;
        if (!$apiKey) {
            $this->markTestSkipped('No TIKAPI_API_KEY set in .env for integration test.');
        }

        $this->tikapi = new TikApi($apiKey);
    }

    public function testPublicCheckEndpointReturnsSuccess()
    {
        $response = $this->tikapi->public()->check()->username('lilyachty');

        $this->assertIsArray($response);
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', strtolower($response['status']));
    }
}
