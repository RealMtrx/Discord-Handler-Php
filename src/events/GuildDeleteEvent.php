<?php

namespace DiscordHandler\events;

use Discord\Parts\Guild\Guild;
use DiscordHandler\config\Config;
use DiscordHandler\core\WebhookUtil;

class GuildDeleteEvent
{
  public static function execute(Guild $guild, Config $config): void
  {
    echo "\x1b[31m[GuildDelete] Left: {$guild->name} ({$guild->id})\x1b[0m" . PHP_EOL;
    WebhookUtil::send(
      $config->guildLogWebhook,
      "**Left Server**\nName: {$guild->name}\nID: {$guild->id}"
    );
  }
}
