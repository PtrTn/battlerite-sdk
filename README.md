# Battlerite-sdk
PHP-based SDK for Battlerite API

[![Build Status](https://travis-ci.org/PtrTn/battlerite-sdk.svg?branch=master)](https://travis-ci.org/PtrTn/battlerite-sdk)
[![Code Coverage](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)

## Features
- Retrieve data for matches (by query)
- Retrieve data for a specific match
- Retrieve data for players (by query) _(not yet supported by API)_
- Retrieve data for a specific player _(not yet supported by API)_

## Requirements
- Php 7.1 or higher

## Installing
`composer require ptrtn/battlerite-sdk`

## Usage
```php
$client = new \PtrTn\Battlerite\Client(
    new \GuzzleHttp\Client(),
    'enter-your-api-key-here'
);
$matches = $client->getMatches();
echo $matches->matches[0]->map->type;
// QUICK2V2
```


## Api documentation
Dcoumentation for the Battlerite API can be found at [http://battlerite-docs.readthedocs.io/en/latest/](http://battlerite-docs.readthedocs.io/en/latest/)