<?php

namespace DiscordHandler\events;

use Discord\Parts\Interactions\Interaction;
use Discord\Parts\Interactions\Command\Command;
use DiscordHandler\commands\slash\PingCommand;
use DiscordHandler\core\Emojis;

class InteractionCreateEvent
{
  public static function execute(Interaction $interaction): void
  {
    if ($interaction->type !== Interaction::TYPE_APPLICATION_COMMAND) return;

    $cmd = $interaction->data->name;

    try {
      match ($cmd) {
        PingCommand::NAME => PingCommand::execute($interaction),
        default => $interaction->respond(
          \Discord\Builders\MessageBuilder::new()
            ->setContent(Emojis::ERROR . ' Unknown command.')
            ->setEphemeral(true)
        ),
      };
    } catch (\Throwable $e) {
      echo "\x1b[31m[InteractionCreate] Error in /{$cmd}: {$e->getMessage()}\x1b[0m" . PHP_EOL;
      if (!$interaction->hasResponded()) {
        $interaction->respond(
          \Discord\Builders\MessageBuilder::new()
            ->setContent(Emojis::ERROR . ' Error executing command!')
            ->setEphemeral(true)
        );
      }
    }
  }
}
