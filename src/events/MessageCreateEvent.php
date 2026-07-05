<?php

namespace DiscordHandler\events;

use Discord\Parts\Channel\Message;
use DiscordHandler\commands\prefix\PingCommand;
use DiscordHandler\core\Emojis;
use DiscordHandler\config\Config;

class MessageCreateEvent
{
  public static function execute(Message $message, Config $config): void
  {
    if ($message->author->bot) return;

    $content = $message->content;
    $prefix = $config->prefix;

    if (!str_starts_with($content, $prefix)) return;

    $parts = explode(' ', substr($content, strlen($prefix)));
    $cmdName = strtolower($parts[0] ?? '');

    try {
      match ($cmdName) {
        PingCommand::NAME => PingCommand::execute($message),
        default => $message->reply(Emojis::ERROR . " Unknown command. Use `{$prefix}help` for a list of commands."),
      };
    } catch (\Throwable $e) {
      echo "\x1b[31m[MessageCreate] Error in prefix command: {$e->getMessage()}\x1b[0m" . PHP_EOL;
    }
  }
}
