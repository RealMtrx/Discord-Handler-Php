<?php

namespace DiscordHandler\commands\prefix;

use Discord\Parts\Channel\Message;
use DiscordHandler\core\Emojis;
use DiscordHandler\core\CommandUtils;

class PingCommand
{
  const NAME = 'ping';

  public static function execute(Message $message): void
  {
    $remaining = CommandUtils::cooldown($message->author->id, 'ping');
    if ($remaining !== null) {
      $message->reply(Emojis::WARNING . " Please wait `{$remaining}s` before using this command again.");
      return;
    }

    $latency = (int) round((microtime(true) - $message->timestamp->timestamp) * 1000);
    $message->reply(Emojis::PING . " **Pong!** \u{1F3D3}\n\u{23F1}\u{FE0F} Latency: `{$latency}ms`");
  }
}
