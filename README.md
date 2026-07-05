<div align="center">
  <h1>Discord Handler — PHP</h1>
  <p><strong>A production-ready Discord bot framework built with DiscordPHP and MongoDB — slash commands, prefix commands, anti-crash, webhook logging, and a modular src/ architecture.</strong></p>

  <p>
    <a href="https://github.com/RealMtrx/Discord-Handler-Php/blob/main/LICENSE"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
    <a href="https://github.com/RealMtrx/Discord-Handler-Php/releases"><img src="https://img.shields.io/badge/version-0.9.0--beta-yellow" alt="Version 0.9.0 Beta"></a>
    <a href="https://github.com/RealMtrx/Discord-Handler-Php/stargazers"><img src="https://img.shields.io/github/stars/RealMtrx/Discord-Handler-Php" alt="Stars"></a>
    <a href="https://github.com/RealMtrx/Discord-Handler-Php/issues"><img src="https://img.shields.io/github/issues/RealMtrx/Discord-Handler-Php" alt="Issues"></a>
    <a href="https://github.com/RealMtrx/Discord-Handler-Php/network"><img src="https://img.shields.io/github/forks/RealMtrx/Discord-Handler-Php" alt="Forks"></a>
    <a href="https://github.com/RealMtrx/Discord-Handler/graphs/contributors"><img src="https://img.shields.io/badge/ecosystem-26%20repos-brightgreen" alt="26 Repos"></a>
    <a href="https://discord.gg/0hu2"><img src="https://img.shields.io/badge/discord-0hu2-5865F2" alt="Discord"></a>
  </p>

  <br>

  <p>
    <a href="#-features">Features</a> •
    <a href="#-quick-start">Quick Start</a> •
    <a href="#-project-structure">Structure</a> •
    <a href="#-api-reference">API</a> •
    <a href="#-database-edition">SQL Edition</a> •
    <a href="#-related-repositories">Ecosystem</a>
  </p>
</div>

---

## Overview

Discord Handler PHP is the **PHP edition** of the multi-language Discord Handler ecosystem. Built on `DiscordPHP` (^7.0) with ReactPHP's async event loop, it provides a modular, event-driven foundation for Discord bots with dual command support (slash + prefix), MongoDB persistence, webhook-based logging, and an anti-crash layer.

The entry point (`src/main.php`) boots in a predictable sequence: initialize the anti-crash handler, connect to MongoDB, create the `Discord` client, attach all five event listeners (READY, GUILD_CREATE, GUILD_DELETE, INTERACTION_CREATE, MESSAGE_CREATE), and finally present a startup report before `$discord->run()` starts the ReactPHP event loop.

## Features

- **Dual Command System** — Slash commands and prefix commands dispatched from event listeners
- **Modular Architecture** — PSR-4 autoloaded classes across `Config/`, `Core/`, `Database/`, `Events/`, `Handlers/`, `Models/`, and `Commands/`
- **Anti-Crash** — Global error interception that reports failures to a Discord webhook
- **Async Runtime** — Non-blocking I/O via ReactPHP event loop (DiscordPHP runs on ReactPHP)
- **Webhook Logging** — Separate webhooks for error alerts and guild join/leave events
- **MongoDB Integration** — Persistent storage via `mongodb/mongodb` (^1.17)
- **Cooldown System** — Per-command cooldown tracked in `Core/CommandUtils.php`
- **Environment Configuration** — All secrets managed through `.env` with `phpdotenv` (^5.6)

## Quick Start

```bash
git clone https://github.com/RealMtrx/Discord-Handler-Php.git
cd Discord-Handler-Php
composer install
```

Copy `.env.example` to `.env` and fill in your values:

```env
TOKEN=your_bot_token_here
PREFIX=!
BOT_NAME=Discord Handler
MONGO_URI=mongodb://localhost:27017/discord-handler
ERROR_WEBHOOK=https://discord.com/api/webhooks/your_webhook
GUILD_LOG_WEBHOOK=https://discord.com/api/webhooks/your_webhook
```

```bash
php src/main.php
```

### Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| `team-reflex/discord-php` | ^7.0 | Discord API wrapper (async) |
| `mongodb/mongodb` | ^1.17 | MongoDB driver |
| `vlucas/phpdotenv` | ^5.6 | Environment variable management |
| PHP | >= 8.1 | Language runtime |

## Project Structure

```
Discord-Handler-Php/
├── composer.json
├── .env.example
├── src/
│   ├── main.php                       # Entry point — boot sequence
│   ├── config/Config.php              # Loads and exposes .env values
│   ├── Core/
│   │   ├── CommandUtils.php           # Cooldown helper
│   │   ├── Emojis.php                 # Centralized emoji constants
│   │   └── WebhookUtil.php            # Webhook dispatch utility
│   ├── Database/Mongo.php             # MongoDB connection wrapper
│   ├── Events/
│   │   ├── GuildCreateEvent.php       # Guild join → webhook
│   │   ├── GuildDeleteEvent.php       # Guild leave → webhook
│   │   ├── InteractionCreateEvent.php # Slash command dispatcher
│   │   ├── MessageCreateEvent.php     # Prefix command dispatcher
│   │   └── ReadyEvent.php             # Ready event + startup report
│   ├── Handlers/
│   │   ├── AntiCrash.php              # Global error interception
│   │   └── Logger.php                 # Startup report formatter
│   ├── Models/UserModel.php           # User data schema
│   └── Commands/
│       ├── Slash/PingCommand.php      # Example slash command
│       └── Prefix/PingCommand.php     # Example prefix command
```

## API Reference

### Entry Point — `src/main.php`

Creates a `Discord` client, wires five event listeners via `$discord->on()`, and calls `$discord->run()` to start the ReactPHP event loop.

### Configuration — `src/config/Config.php`

```php
$config->token          // Bot token
$config->prefix         // Command prefix (default: "!")
$config->botName        // Display name
$config->mongoUri       // MongoDB connection string
$config->errorWebhook   // Error reporting URL
$config->guildLogWebhook // Guild event logging URL
```

### Events

| Event | File | Trigger |
|-------|------|---------|
| `READY` | `Events/ReadyEvent.php` | Bot goes online — logs startup |
| `GUILD_CREATE` | `Events/GuildCreateEvent.php` | Bot joins a server — sends join webhook |
| `GUILD_DELETE` | `Events/GuildDeleteEvent.php` | Bot leaves a server — sends leave webhook |
| `INTERACTION_CREATE` | `Events/InteractionCreateEvent.php` | Slash command used — routes to command class |
| `MESSAGE_CREATE` | `Events/MessageCreateEvent.php` | Message sent — checks prefix, routes to prefix command |

### Core Utilities

- **CommandUtils** — `CommandUtils::checkCooldown($command, $userId)` checks cooldown expiry
- **WebhookUtil** — `WebhookUtil::send($webhookUrl, $content)` fires an embed to a Discord webhook
- **Emojis** — Centralized emoji constant map for consistent bot responses

## Adding Commands

### Slash Command

Create `src/Commands/Slash/YourCommand.php`:

```php
namespace DiscordHandler\Commands\Slash;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Interaction;

class YourCommand
{
    const NAME = 'yourcommand';
    const DESCRIPTION = 'Does something useful';

    public static function execute(Interaction $interaction): void
    {
        $interaction->respond(
            MessageBuilder::new()->setContent('Done!')
        );
    }
}
```

Then register it in `src/Events/ReadyEvent.php`:

```php
$discord->application->commands->save(
    $discord->application->commands->create(YourCommand::NAME, YourCommand::DESCRIPTION)
);
```

### Prefix Command

Create `src/Commands/Prefix/YourCommand.php`:

```php
namespace DiscordHandler\Commands\Prefix;

use Discord\Parts\Channel\Message;

class YourCommand
{
    const NAME = 'yourcommand';

    public static function execute(Message $message): void
    {
        $message->reply('Done!');
    }
}
```

The `MessageCreateEvent` automatically dispatches to classes in `Commands/Prefix/` when the message starts with `PREFIX`.

## Database Edition

A **Sequelize (SQL)** variant of this handler is available for teams that prefer a relational database over MongoDB:

[RealMtrx/Discord-Handler-Php-Sequelize](https://github.com/RealMtrx/Discord-Handler-Php-Sequelize)

It replaces `Database/Mongo.php` with a Sequelize-based connection and supports SQLite, PostgreSQL, MySQL, MariaDB, and MSSQL out of the box. All other modules — events, commands, handlers, core utilities — remain identical.

## Related Repositories

The Discord Handler ecosystem spans **26 repositories** across 13 languages, each available in both MongoDB and Sequelize editions.

### Base Repositories (MongoDB)

| Language | Repository |
|----------|------------|
| C++ | [RealMtrx/Discord-Handler-Cpp](https://github.com/RealMtrx/Discord-Handler-Cpp) |
| C# | [RealMtrx/Discord-Handler-Cs](https://github.com/RealMtrx/Discord-Handler-Cs) |
| Dart | [RealMtrx/Discord-Handler-Dart](https://github.com/RealMtrx/Discord-Handler-Dart) |
| Go | [RealMtrx/Discord-Handler-Go](https://github.com/RealMtrx/Discord-Handler-Go) |
| Java | [RealMtrx/Discord-Handler-Java](https://github.com/RealMtrx/Discord-Handler-Java) |
| JavaScript | [RealMtrx/Discord-Handler-Js](https://github.com/RealMtrx/Discord-Handler-Js) |
| Kotlin | [RealMtrx/Discord-Handler-Kt](https://github.com/RealMtrx/Discord-Handler-Kt) |
| Lua | [RealMtrx/Discord-Handler-Lua](https://github.com/RealMtrx/Discord-Handler-Lua) |
| PHP | [RealMtrx/Discord-Handler-Php](https://github.com/RealMtrx/Discord-Handler-Php) |
| Python | [RealMtrx/Discord-Handler-Py](https://github.com/RealMtrx/Discord-Handler-Py) |
| Ruby | [RealMtrx/Discord-Handler-Rb](https://github.com/RealMtrx/Discord-Handler-Rb) |
| Rust | [RealMtrx/Discord-Handler-Rs](https://github.com/RealMtrx/Discord-Handler-Rs) |
| TypeScript | [RealMtrx/Discord-Handler](https://github.com/RealMtrx/Discord-Handler) ← hub |

### Sequelize (SQL) Editions

| Language | Repository |
|----------|------------|
| C++ | [RealMtrx/Discord-Handler-Cpp-Sequelize](https://github.com/RealMtrx/Discord-Handler-Cpp-Sequelize) |
| C# | [RealMtrx/Discord-Handler-Cs-Sequelize](https://github.com/RealMtrx/Discord-Handler-Cs-Sequelize) |
| Dart | [RealMtrx/Discord-Handler-Dart-Sequelize](https://github.com/RealMtrx/Discord-Handler-Dart-Sequelize) |
| Go | [RealMtrx/Discord-Handler-Go-Sequelize](https://github.com/RealMtrx/Discord-Handler-Go-Sequelize) |
| Java | [RealMtrx/Discord-Handler-Java-Sequelize](https://github.com/RealMtrx/Discord-Handler-Java-Sequelize) |
| JavaScript | [RealMtrx/Discord-Handler-Js-Sequelize](https://github.com/RealMtrx/Discord-Handler-Js-Sequelize) |
| Kotlin | [RealMtrx/Discord-Handler-Kt-Sequelize](https://github.com/RealMtrx/Discord-Handler-Kt-Sequelize) |
| Lua | [RealMtrx/Discord-Handler-Lua-Sequelize](https://github.com/RealMtrx/Discord-Handler-Lua-Sequelize) |
| PHP | [RealMtrx/Discord-Handler-Php-Sequelize](https://github.com/RealMtrx/Discord-Handler-Php-Sequelize) |
| Python | [RealMtrx/Discord-Handler-Py-Sequelize](https://github.com/RealMtrx/Discord-Handler-Py-Sequelize) |
| Ruby | [RealMtrx/Discord-Handler-Rb-Sequelize](https://github.com/RealMtrx/Discord-Handler-Rb-Sequelize) |
| Rust | [RealMtrx/Discord-Handler-Rs-Sequelize](https://github.com/RealMtrx/Discord-Handler-Rs-Sequelize) |
| TypeScript | [RealMtrx/Discord-Handler-Ts-Sequelize](https://github.com/RealMtrx/Discord-Handler-Ts-Sequelize) |

> **[RealMtrx/Discord-Handler](https://github.com/RealMtrx/Discord-Handler)** — the TypeScript hub and flagship repository. Star it to support the ecosystem.

## License

Distributed under the MIT License. See `LICENSE` for more information.

---

Built by **Mtrx** — Discord: **0hu2**
