# Battlerite-sdk
PHP-based SDK for Battlerite API

[![Build Status](https://travis-ci.org/PtrTn/battlerite-sdk.svg?branch=master)](https://travis-ci.org/PtrTn/battlerite-sdk)
[![Code Coverage](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)

## Requirements
- Php 7.1 or higher

## Installing
`composer require ptrtn/battlerite-sdk`

## Usage
```php
$client = new \PtrTn\Battlerite\Client
$matches = $client->getMatches();
echo $matches[0]->map->type;
// QUICK2V2
```