# Battlerite-sdk
PHP-based SDK for Battlerite API

[![Build Status](https://travis-ci.org/PtrTn/battlerite-sdk.svg?branch=master)](https://travis-ci.org/PtrTn/battlerite-sdk)
[![Code Coverage](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/PtrTn/battlerite-sdk/?branch=master)

## Features
- Retrieve data for matches (by query)
- Retrieve detailed data for a specific match
- Retrieve data for players (by query)
- Retrieve detailed data for a specific player
- Retrieve team data for specific players and seasons
- Retrieve api status

## Requirements
- Php 7.1 or higher

## Installing
`composer require ptrtn/battlerite-sdk`

## Usage
Retrieving data can be as simple as one method call.
If no search query is specified, API defaults are used instead.
### Api status
The following example returns API status, patch version and other data
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
$status = $client->getStatus();
```
### Retrieving match data
Retrieving match data using API defaults
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
$matches = $client->getMatches();
echo $matches[0]->map->type;
// QUICK2V2
```
### Retrieving team data
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
$teams = $client->getTeams(
    TeamsQuery::create()
    ->forPlayerIds(['322'])
    ->forSeason(5)
);
```
### Retrieving detailed match data
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
$match = $client->getMatch('AB9C81FABFD748C8A7EC545AA6AF97CC');
```
### Retrieving detailed player data
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
$match = $client->getPlayer('934791968557563904');
```
### Custom querying
A custom search query can be used to retrieve the exact data needed.
#### Matches
For matches the following query options are available:
- Offset
- Limit
- Start date
- End date
- Player ids
- Team names
- Game modes
- Ascending sorting
- Descending sorting
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
// Retrieve matches for a specific player for the last 24 hours
$matches = $client->getMatches(
    MatchesQuery::create()
    ->forPlayerIds(['934791968557563904'])
    ->withStartDate(new DateTime('-1 day'))
);
```
#### Players
For players the following query options are available:
- Player name
- Steam id
- Player id
```php
$client = \PtrTn\Battlerite\Client::create('your-api-key');
// Retrieve a list of players for a specific player name
$players = $client->getPlayers(
    PlayersQuery::create()
    ->forPlayerNames(['PlakkeStrasser'])
);
```
_Note: up to 6 players (1 per region) can be found for a specific player name._
#### Teams
For teams the following query options are available:
 - Season
 - Player id
 ```php
 $client = \PtrTn\Battlerite\Client::create('your-api-key');
 $teams = $client->getTeams(
     TeamsQuery::create()
     ->forPlayerIds(['322'])
     ->forSeason(5)
 );
 ```

## Caching
When sending a lot of requests, the default rate limit of 10 requests per minute will pose an issue.
In order to prevent this, caching can be enabled for the player details and match details endpoints.
```php
// Create client using default filesystem cache
$client = ClientWithCache::create('your-api-key');
```
Optionally an alternative cache lifetime or caching system implementing the `Doctrine\Common\Cache\Cache` interface can be configured.
```php
// Create a client using custom configured cache
$client = ClientWithCache::createWithCache(
    'your-api-key',
    new RedisCache(),
    300
);
```

## How do I get an API key?
1. In order to get an API key you should [create a developer account and an app](https://developer.battlerite.com/users/sign_in)
2. Once created, log in and browse to [https://developer.battlerite.com/apps/your-app](https://developer.battlerite.com/apps/your-app)
3. Scroll down to **DEVELOPMENT API KEY THIS APP USES**, it should look like:
```eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9G9lIiwiYWRtaW4iOnRydWV9G9lIi.TJVA95OrM7E2cBab30RMHrHDcEfxjoYZgeFONFh7HgQ```

## Api documentation
Documentation for the Battlerite API can be found at [http://battlerite-docs.readthedocs.io/en/latest/](http://battlerite-docs.readthedocs.io/en/latest/)