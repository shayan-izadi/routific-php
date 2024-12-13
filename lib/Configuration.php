<?php

namespace Routific;

use Routific\Api\VehicleRoutingApi;
use Routific\Api\PickupDeliveryApi;
use Routific\Api\JobApi;

class Configuration
{

    protected $apiKey;
    protected $visits;
    protected $vehicles;
    public $jobApi;
    public $vehicleApi;
    public $pickupDelivery;

    public function __construct()
    {
        $this->vehicleApi = new VehicleRoutingApi($this);
        $this->pickupDelivery = new PickupDeliveryApi($this);
        $this->jobApi = new JobApi($this);
    }

    public function setApiKey($key)
    {
        $this->apiKey = $key;
        return $this;
    }

    public function getApiKey()
    {
        return isset($this->apiKey) ? $this->apiKey : null;
    }

    public function setVisits($visits)
    {
        $this->visits = $visits;
        return $this;
    }

    public function getVisits()
    {
        return isset($this->visits) ? $this->visits : null;
    }

    public function setVehicles($vehicles)
    {
        $this->vehicles = $vehicles;
        return $this;
    }

    public function getVehicles()
    {
        return isset($this->vehicles) ? $this->vehicles : null;
    }
}
