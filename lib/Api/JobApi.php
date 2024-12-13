<?php

namespace Routific\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ConnectException;
use Routific\Configuration;

class JobApi
{

    protected $config;
    protected $client;
    protected $jobID;
    protected $endPoint = "https://api.routific.com/jobs/";

    public function __construct(Configuration $config = null)
    {
        $this->client = new Client([
            'base_uri' => $this->endPoint
        ]);
        $this->config = $config ?: new Configuration();
    }

    public function getJobDetails($jobId)
    {
        // Base URL for the API
        $baseUrl = $this->endPoint;

        // Full URL with the unique job ID
        $url = $baseUrl . $jobId;

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    "Authorization" => "bearer " . $this->config->getApiKey(),
                    "Content-type" => "application/json"
                ]
            ]);


            $responseBody = $response->getBody();
            $content = $responseBody->getContents();
            $data = json_decode($content, true);

            return $data;
        } catch (RequestException $e) {
            $errorResponse = [
                'error' => 'Failed to retrieve job details',
                'message' => $e->getMessage()
            ];

            if ($e->hasResponse()) {
                $errorResponse['status_code'] = $e->getResponse()->getStatusCode();
                $errorResponse['body'] = $e->getResponse()->getBody()->getContents();
            }

            return $errorResponse;
        }
    }
}
