# Discord Handler PHP

A modern, feature-rich Discord bot handler built with PHP and DiscordPHP, featuring both slash commands and prefix commands with a robust modular architecture.

## Features

- Slash commands and prefix commands
- MongoDB integration with mongodb/mongodb
- Modular architecture (commands, events, handlers)
- Anti-crash system with error reporting
- Cooldown system
- Unicode emoji exports
- Webhook logging

## Prerequisites

- PHP 8.1+
- Composer

## Setup

1. Clone the repository
2. Copy `.env.example` to `.env` and fill in your bot token and other configuration
3. Install dependencies:
```bash
composer install
```
4. Run the bot:
```bash
php src/main.php
```

## Project Structure

```
src/
├── main.php                    # Entry point
├── config/Config.php           # Configuration loader
├── commands/slash/PingCommand.php # Slash ping command
├── commands/prefix/PingCommand.php # Prefix ping command
├── core/Emojis.php             # Unicode emoji exports
├── core/CommandUtils.php       # Cooldown utilities
├── core/WebhookUtil.php        # Webhook utility
├── database/Mongo.php          # MongoDB connection
├── events/ReadyEvent.php       # Ready event
├── events/GuildCreateEvent.php # Guild join event
├── events/GuildDeleteEvent.php # Guild leave event
├── events/InteractionCreateEvent.php # Slash command handler
├── events/MessageCreateEvent.php     # Prefix command handler
├── handlers/AntiCrash.php      # Error handling
├── handlers/Logger.php         # Startup logger
└── models/UserModel.php        # User data model
```

## License

MIT License - see [LICENSE](LICENSE) for details.
