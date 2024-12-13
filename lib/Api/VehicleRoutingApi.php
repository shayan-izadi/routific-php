<?php

namespace Routific\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Routific\Configuration;

class VehicleRoutingApi
{

    protected $config;
    protected $client;
    protected $base_url = "https://api.routific.com/v1/";

    public function __construct(Configuration $config = null)
    {
        $this->client = new Client([
            'base_uri' => $this->base_url
        ]);
        $this->config = $config ?: new Configuration();
    }

    public function optimizeRoute($long = false)
    {
        $payload = array(
            "visits" => $this->config->getVisits(),
            "fleet" => $this->config->getVehicles()
        );

        $endpPoint = 'vrp';
        if ($long == true) {
            $endpPoint = 'vrp-long';
        }

        try {
            $response = $this->client->post($endpPoint, [
                'json' => $payload,
                'headers' => [
                    "Content-type" => "application/json",
                    "Authorization" => "bearer " . $this->config->getApiKey()
                ]
            ]);

            $responseBody = $response->getBody();
            $content = $responseBody->getContents();
            $content = json_decode($content, true);

            return $content;
        } catch (ClientException $e) {
            // Handle 4xx errors
            return [
                'error' => 'Client error',
                'message' => $e->getMessage(),
                'status_code' => $e->getResponse()->getStatusCode()
            ];
        } catch (ServerException $e) {
            // Handle 5xx errors
            return [
                'error' => 'Server error',
                'message' => $e->getMessage(),
                'status_code' => $e->getResponse()->getStatusCode()
            ];
        } catch (ConnectException $e) {
            // Handle network errors
            return [
                'error' => 'Connection error',
                'message' => $e->getMessage()
            ];
        } catch (RequestException $e) {
            // Handle other errors (e.g., malformed request)
            return [
                'error' => 'Request error',
                'message' => $e->getMessage()
            ];
        }
    }
}
