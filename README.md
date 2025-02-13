# Routific PHP
The Routific PHP library provides convenient access to the Routific API from applications written in the PHP language. It includes a pre-defined set of classes for API resources that initialize themselves dynamically from API responses.

## Requirements

PHP 7.2.0 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require shayanizadi/routific
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Getting Started

Simply set your [Routific API key](https://docs.routific.com/reference/get-your-api-key):

```php
$routific= new \Routific\ApiClient;
$routific->setApiKey('YOUR_API_KEY');
```

## Documentation

See the [Routific API docs](https://docs.routific.com/reference/api-reference).

## SET VISITS

First step you must set up your visit endpoints :

```php
$order1 = array(
    "location" => array(
      "name" => "6800 Cambie",
      "lat" => 49.227107,
      "lng" => -123.1163085
));
$order2 = array(
    "location" => array(
      "name" => "3780 Arbutus",
      "lat" => 49.2474624,
      "lng" => -123.1532338
));
$order3 = array(
    "location" => array(
      "name" => "800 Robson",
      "lat" => 49.2819229,
      "lng" => -123.1211844
));
$visits = array(
    "order_1" => $order1,
    "order_2" => $order2,
    "order_3" => $order3
);

$routific->setVisits($visits);
```

## SET VEHICLES

Then you can define your vehicles (drivers) :


```php

$vehicle1 = array(
    "start_location" => array(
      "id" => "depot",
      "name" => "800 Kingsway",
      "lat" => 49.2553636,
      "lng" => -123.0873365
));
  
$vehicle2 = array(
    "start_location" => array(
      "id" => "depot",
      "name" => "800 Kingsway",
      "lat" => 49.2553636,
      "lng" => -123.0873365
));
  
$vehicles = array(
    "vehicle_1" => $vehicle1,
    "vehicle_2" => $vehicle2,
);

$routific->setVehicles($vehicles);

```
## Optimize Route for Vehicle Routing

Now you can choose based on your purpose to use API that suits your situation

If you want use just vehicle routing optimization:

```php
$routific->vehicleApi->optimizeRoute();
```

## Optimize Route for Pickup & Delivery

If you are looking for Pickup and Delivery optimizer :

```php
$routific->pickupDelivery->optimizeRoute();
```

## Use Long Running tasks API

If you wish to use [Long Running Tasks Api](https://docs.routific.com/reference/vrp-long), you have to simply set input for  optimizeRoute as TRUE:

```php
$key=$routific->vehicleApi->optimizeRoute(TRUE);
 //OR
$key=$routific->pickupDelivery->optimizeRoute(TRUE);

```

Then you have to retrieve job that has been created:

```php

$routific->jobApi->getJobDetails($key['job_id'])

```

## For running tests

If you wish to run tests, first you must change composer in this way:

```bash
"autoload": {
        "psr-4": {
            "ShayanIzadi\\Routific\\": "lib/"
        }
    },

 //to
 
"autoload": {
        "psr-4": {
            "Routific\\": "lib/"
        }
    },

```

Then run dump autoload command

```bash

   composer dump-autoload

```


## Appreciate Contributions
We welcome contributions from everyone! If you'd like to contribute to this project, follow these steps:

1- Fork the repository.
2- Create a new branch for your feature or bug fix
3- Commit your changes and push your branch
4- Open a pull request and explain your changes.

Your contributions will help make this project even better. Thank you for your support!

## License

This project is licensed under the MIT License.
You are free to use, modify, and distribute this project as long as you include the original license file. For more details, see the [LICENSE file](https://github.com/shayan-izadi/routific-php/blob/main/LICENSE) .