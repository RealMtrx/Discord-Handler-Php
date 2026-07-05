<?php

namespace DiscordHandler\commands\slash;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Interaction;
use DiscordHandler\core\Emojis;

class PingCommand
{
  const NAME = 'ping';
  const DESCRIPTION = 'Replies with Pong!';

  public static function execute(Interaction $interaction): void
  {
    $latency = (int) round((microtime(true) - ($interaction->id >> 22) / 1000) * 1000);
    $interaction->respond(
      MessageBuilder::new()
        ->setContent(Emojis::PING . " **Pong!** \u{1F3D3}\n\u{23F1}\u{FE0F} Latency: `{$latency}ms`")
    );
  }
}
