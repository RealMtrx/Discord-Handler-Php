<?php

namespace DiscordHandler\events;

use Discord\Parts\Guild\Guild;
use DiscordHandler\config\Config;
use DiscordHandler\core\WebhookUtil;

class GuildCreateEvent
{
  public static function execute(Guild $guild, Config $config): void
  {
    echo "\x1b[32m[GuildCreate] Joined: {$guild->name} ({$guild->id})\x1b[0m" . PHP_EOL;
    WebhookUtil::send(
      $config->guildLogWebhook,
      "**Joined Server**\nName: {$guild->name}\nID: {$guild->id}\nMembers: {$guild->member_count}"
    );
  }
}
