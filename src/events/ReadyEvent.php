<?php

namespace DiscordHandler\events;

use Discord\Discord;
use Discord\Parts\Interactions\Command\Command;
use DiscordHandler\config\Config;

class ReadyEvent
{
  public static function execute(Discord $discord, Config $config): void
  {
    $discord->updatePresence(\Discord\Parts\User\Activity::new($discord, [
      'name' => "with {$config->botName}",
      'type' => \Discord\Parts\User\Activity::TYPE_PLAYING,
    ]));

    echo "\x1b[32m[Ready] Logged in as {$discord->user->username}#{$discord->user->discriminator}\x1b[0m" . PHP_EOL;

    // Register slash commands
    $command = new Command($discord, [
      'name' => 'ping',
      'description' => 'Replies with Pong!',
      'type' => Command::CHAT_INPUT,
    ]);

    $discord->application->commands->save($command)->done(function () {
      echo "\x1b[32m[Commands] Slash command 'ping' registered\x1b[0m" . PHP_EOL;
    });
  }
}
