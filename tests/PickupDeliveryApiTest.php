<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Routific\Api\PickupDeliveryApi;
use Routific\Configuration;

class PickupDeliveryApiTest extends TestCase
{
    private $mockClient;
    private $mockConfig;

    protected function setUp() : void
    {
        $this->mockClient=$this->createMock(Client::class);
        $this->mockConfig=$this->createMock(Configuration::class);
        $this->mockConfig->method('getVisits')->willReturn(['visit1' => []]);
        $this->mockConfig->method('getVehicles')->willReturn(['vehicle1' => []]);
        $this->mockConfig->method('getApiKey')->willReturn('test-api-key');
    }

    public function testOptimizeRouteReturnsContent()
    {
        $mockResponse= new Response(200,[],'{"status":"success"}');
        $this->mockClient->method('post')->willReturn($mockResponse);

        $api = new PickupDeliveryApi($this->mockConfig);

        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        
        $result = $api->optimizeRoute();
        $this->assertJson($result);
        $this->assertStringContainsString('success', $result);
    }

    public function testOptimizeRouteHandlesClientException()
    {
        $this->mockClient->method('post')->willThrowException($this->createMock(ClientException::class));
        $api = new PickupDeliveryApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        $result = $api->optimizeRoute();
        $this->assertArrayHasKey('error', $result);
    }

    public function testOptimizeRouteHandlesServerException()
    {
        $this->mockClient->method('post')->willThrowException($this->createMock(ServerException::class));
        $api = new PickupDeliveryApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        $result = $api->optimizeRoute();
        $this->assertArrayHasKey('error', $result);
    }

    public function testOptimizeRouteHandlesConnectException()
    {
        $this->mockClient->method('post')->willThrowException($this->createMock(ConnectException::class));
        $api = new PickupDeliveryApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        $result = $api->optimizeRoute();
        $this->assertArrayHasKey('error', $result);
    }

    public function testOptimizeRouteHandlesRequestException()
    {
        $this->mockClient->method('post')->willThrowException($this->createMock(RequestException::class));
        $api = new PickupDeliveryApi($this->mockConfig);
        $reflection = new \ReflectionClass($api);
        $property = $reflection->getProperty('client');
        $property->setAccessible(true);
        $property->setValue($api, $this->mockClient);
        $result = $api->optimizeRoute();
        $this->assertArrayHasKey('error', $result);
    }
}


?>