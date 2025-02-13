<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Routific\Api\JobApi;
use Routific\Configuration;

class JobApiTest extends TestCase
{
    private $mockClient;
    private $mockConfig;

    protected function setUp() : void
    {
        $this->mockClient=$this->createMock(Client::class);
        $this->mockConfig=$this->createMock(Configuration::class);
        $this->mockConfig->method('getApiKey')->willReturn('test-api-key');
    }

    public function testOptimizeRouteReturnsContent()
    {
        $mockResponse = new Response(200, [], '{"status":"success"}');
        $this->mockClient->method('get')->willReturn($mockResponse);

        $api = new JobApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);

        $result = $api->getJobDetails('123');
        $this->assertJson($result);
        $this->assertStringContainsString('success', $result);
    }

    public function testGetJobDetailsHandlesRequestException()
    {
        $this->mockClient->method('get')->willThrowException($this->createMock(RequestException::class));
        $api = new JobApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        $result = $api->getJobDetails('123');
        $this->assertArrayHasKey('error', $result);
    }
}