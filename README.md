# Ploi PHP SDK :rocket:

The future is now - so stop the hassle, you’re running behind. Quick and easy site deployment with Ploi. Awesome features for awesome developers. Check it out at www.ploi.io

This SDK is ment for PHP applications to be able to communicate with our API.
You can find our documentation at https://developers.ploi.io

## Installation

```bash
composer require ploi/ploi-php-sdk
```

## Usage

First you need to call a new Ploi instance

```php
$ploi = new \Ploi\Ploi($apiToken);
// or
$ploi = new \Ploi\Ploi();
$ploi->setApiToken($token);
```

### Responses
When calling a resource, it will return an array containing decoded JSON as well as the original response from the Guzzle client.

```json
[
    "json" : {
        "id": 123,
        "name": "server-name",
        "ip_address": "XXX.XXX.XXX.XXX",
        "php_version": 7.1,
        "mysql_version": 5.7,
        "sites_count": 3,
        "status": "Server active",
        "created_at": "2018-01-01 08:00:00",
     },
     "response" : GuzzleHttp\Psr7\Response,
]
```

## Resources

Resources are what you call to access a feature or function. 

### Servers

Get all servers

```php
$ploi->server()->get();
```

Get a specific server

```php
$ploi->server(123)->get();
// or
$ploi->server()->get(123);
```

Get a servers deployment logs

```php
$ploi->server(123)->logs();
// or
$ploi->server()->logs(123);
```
