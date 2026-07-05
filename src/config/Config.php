<?php

namespace DiscordHandler\config;

class Config
{
  public string $token;
  public string $prefix;
  public string $botName;
  public string $ownerId;
  public string $mongoUri;
  public string $errorWebhook;
  public string $guildLogWebhook;

  public function __construct()
  {
    $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
    $dotenv->safeLoad();

    $this->token = $_ENV['TOKEN'] ?? '';
    $this->prefix = $_ENV['PREFIX'] ?? '!';
    $this->botName = $_ENV['BOT_NAME'] ?? 'Discord Handler';
    $this->ownerId = $_ENV['OWNER_ID'] ?? '';
    $this->mongoUri = $_ENV['MONGO_URI'] ?? 'mongodb://localhost:27017/discord-handler';
    $this->errorWebhook = $_ENV['ERROR_WEBHOOK'] ?? '';
    $this->guildLogWebhook = $_ENV['GUILD_LOG_WEBHOOK'] ?? '';
  }
}
