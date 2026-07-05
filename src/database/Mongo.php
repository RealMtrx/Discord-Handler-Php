<?php

namespace DiscordHandler\database;

use MongoDB\Client as MongoClient;

class Mongo
{
  private static ?MongoClient $client = null;
  private static bool $connected = false;

  public static function connect(string $uri): bool
  {
    try {
      self::$client = new MongoClient($uri);
      self::$client->selectDatabase('admin')->command(['ping' => 1]);
      self::$connected = true;
      echo "\x1b[32m[System] MongoDB connected\x1b[0m" . PHP_EOL;
    } catch (\Throwable $e) {
      echo "\x1b[31m[MongoDB] Connection failed: {$e->getMessage()}\x1b[0m" . PHP_EOL;
    }
    return self::$connected;
  }

  public static function isConnected(): bool
  {
    return self::$connected;
  }

  public static function getClient(): ?MongoClient
  {
    return self::$client;
  }
}
