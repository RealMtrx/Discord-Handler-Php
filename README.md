# Discord Handler PHP

A modern, feature-rich Discord bot handler built with **DiscordPHP**, featuring both slash commands and prefix commands with a robust modular architecture designed for scalability and maintainability.

## 🚀 Features

- **Dual Command System**: Support for both slash commands and prefix commands
- **Modular Architecture**: Clean separation of concerns with dedicated handlers
- **Anti-Crash System**: Comprehensive error handling and monitoring
- **Event-Driven**: Fully event-driven async architecture with ReactPHP
- **Webhook Logging**: Real-time logging for errors and guild events
- **MongoDB Integration**: Persistent data storage with mongodb/mongodb
- **Cooldown System**: Per-command cooldown management
- **Environment Configuration**: Secure configuration with phpdotenv

## 📁 Project Structure

```
Discord-Handler-Php/
├── composer.json                 # Composer project configuration
├── src/                          # Source code
│   ├── main.php                  # Main bot entry point
│   ├── Config/Config.php         # Bot configuration from .env
│   ├── Core/                     # Core utilities
│   │   ├── CommandUtils.php      # Cooldown and utilities
│   │   ├── Emojis.php            # Centralized emoji definitions
│   │   └── WebhookUtil.php       # Webhook utility
│   ├── Database/
│   │   └── Mongo.php             # MongoDB connection setup
│   ├── Events/                   # Discord event handlers
│   │   ├── GuildCreateEvent.php  # Handler when bot joins a server
│   │   ├── GuildDeleteEvent.php  # Handler when bot leaves a server
│   │   ├── InteractionCreateEvent.php # Handles slash command interactions
│   │   ├── MessageCreateEvent.php# Handles prefix commands
│   │   └── ReadyEvent.php        # Bot ready event
│   ├── Handlers/                 # Handlers for modularity
│   │   ├── AntiCrash.php         # Crash prevention and error handling
│   │   └── Logger.php            # Logger for bot activity
│   ├── Models/
│   │   └── UserModel.php         # User data model
│   └── Commands/
│       ├── Slash/                # Slash commands
│       │   └── PingCommand.php   # Example slash ping command
│       └── Prefix/               # Prefix commands
│           └── PingCommand.php   # Example prefix ping command
```

## 🔧 Installation

1. **Clone the repository**

   ```bash
   git clone https://github.com/RealMtrx/Discord-Handler-Php.git
   cd Discord-Handler-Php
   ```

2. **Install dependencies**

   ```bash
   composer install
   ```

3. **Environment Setup**

   Copy `.env.example` to `.env` and fill in your values:

   ```env
   TOKEN=your_bot_token_here
   PREFIX=!
   BOT_NAME=Discord Handler
   MONGO_URI=mongodb://localhost:27017/discord-handler
   ERROR_WEBHOOK=https://discord.com/api/webhooks/your_webhook
   GUILD_LOG_WEBHOOK=https://discord.com/api/webhooks/your_webhook
   ```

4. **Run the bot**

   ```bash
   php src/main.php
   ```

## 📋 Dependencies

- **DiscordPHP**: ^7.0 - Discord API wrapper
- **mongodb/mongodb**: ^1.17 - MongoDB driver
- **vlucas/phpdotenv**: ^5.6 - Environment variable management

## 📝 Command Development

### Creating Slash Commands

Create a new file in `src/Commands/Slash/[name]Command.php`:

```php
namespace DiscordHandler\Commands\Slash;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Interactions\Interaction;

class PingCommand
{
    const NAME = 'ping';
    const DESCRIPTION = 'Replies with Pong!';

    public static function execute(Interaction $interaction): void
    {
        $interaction->respond(
            MessageBuilder::new()->setContent('Pong! 🏓')
        );
    }
}
```

### Creating Prefix Commands

Create a new file in `src/Commands/Prefix/[name]Command.php`:

```php
namespace DiscordHandler\Commands\Prefix;

use Discord\Parts\Channel\Message;

class PingCommand
{
    const NAME = 'ping';

    public static function execute(Message $message): void
    {
        $message->reply('Pong! 🏓');
    }
}
```

---

**Discord Handler** — Built by **Mtrx** — Discord: **0hu2**
