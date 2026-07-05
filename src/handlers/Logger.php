<?php

namespace DiscordHandler\handlers;

class Logger
{
  public static function startupReport(array $data): void
  {
    $mongoStatus = $data['mongo'] ? "\x1b[32mConnected\x1b[0m" : "\x1b[31mDisconnected\x1b[0m";
    $acStatus = $data['anticrash'] ? "\x1b[32mActive\x1b[0m" : "\x1b[31mDisabled\x1b[0m";

    echo PHP_EOL;
    echo "\x1b[36m" . str_repeat('=', 50) . "\x1b[0m" . PHP_EOL;
    echo "\x1b[36m   {$data['name']} — Startup Report\x1b[0m" . PHP_EOL;
    echo "\x1b[36m" . str_repeat('=', 50) . "\x1b[0m" . PHP_EOL;
    echo "  \x1b[33mPrefix Commands:\x1b[0m    {$data['prefix']}" . PHP_EOL;
    echo "  \x1b[33mSlash Commands:\x1b[0m     {$data['slash']}" . PHP_EOL;
    echo "  \x1b[33mEvents Loaded:\x1b[0m      {$data['events']}" . PHP_EOL;
    echo "  \x1b[33mAntiCrash:\x1b[0m          {$acStatus}" . PHP_EOL;
    echo "  \x1b[33mMongoDB:\x1b[0m            {$mongoStatus}" . PHP_EOL;
    echo "\x1b[36m" . str_repeat('=', 50) . "\x1b[0m" . PHP_EOL;
    echo "\x1b[32m  Bot is fully operational!\x1b[0m" . PHP_EOL . PHP_EOL;
  }
}
