<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Discord\Discord;
use Discord\WebSockets\Event;
use DiscordHandler\config\Config;
use DiscordHandler\events\ReadyEvent;
use DiscordHandler\events\GuildCreateEvent;
use DiscordHandler\events\GuildDeleteEvent;
use DiscordHandler\events\InteractionCreateEvent;
use DiscordHandler\events\MessageCreateEvent;
use DiscordHandler\handlers\AntiCrash;
use DiscordHandler\handlers\Logger;
use DiscordHandler\database\Mongo;

echo "\x1b[36m\u{2554}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2557}\x1b[0m" . PHP_EOL;
echo "\x1b[36m\u{2551}     Starting Discord Handler     \u{2551}\x1b[0m" . PHP_EOL;
echo "\x1b[36m\u{255A}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{2550}\u{255D}\x1b[0m" . PHP_EOL;
echo PHP_EOL;

$config = new Config();

echo "\x1b[34m[System] Initializing AntiCrash...\x1b[0m" . PHP_EOL;
AntiCrash::init($config->errorWebhook);

echo "\x1b[34m[System] Connecting to MongoDB...\x1b[0m" . PHP_EOL;
$mongoConnected = Mongo::connect($config->mongoUri);

$discord = new Discord(['token' => $config->token]);

$discord->on(Event::READY, function (Discord $discord) use ($config, $mongoConnected) {
  ReadyEvent::execute($discord, $config);

  Logger::startupReport([
    'name' => $config->botName,
    'prefix' => 1,
    'slash' => 1,
    'events' => 5,
    'anticrash' => true,
    'mongo' => $mongoConnected,
  ]);
});

$discord->on(Event::GUILD_CREATE, function (object $guild, Discord $discord) use ($config) {
  GuildCreateEvent::execute($guild, $config);
});

$discord->on(Event::GUILD_DELETE, function (object $guild, Discord $discord) use ($config) {
  GuildDeleteEvent::execute($guild, $config);
});

$discord->on(Event::INTERACTION_CREATE, function (object $interaction, Discord $discord) {
  InteractionCreateEvent::execute($interaction);
});

$discord->on(Event::MESSAGE_CREATE, function (object $message, Discord $discord) use ($config) {
  MessageCreateEvent::execute($message, $config);
});

$discord->run();
