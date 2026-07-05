<?php

namespace DiscordHandler\core;

class CommandUtils
{
  private static array $cooldowns = [];

  public static function cooldown(string $userId, string $command, int $seconds = 3): ?float
  {
    $key = "$userId:$command";
    $now = microtime(true);
    if (isset(self::$cooldowns[$key])) {
      $elapsed = $now - self::$cooldowns[$key];
      if ($elapsed < $seconds) {
        return round($seconds - $elapsed, 1);
      }
    }
    self::$cooldowns[$key] = $now;
    return null;
  }
}
