<?php

namespace DiscordHandler\handlers;

use DiscordHandler\core\WebhookUtil;

class AntiCrash
{
  private static string $webhookUrl = '';

  public static function init(string $webhookUrl = ''): void
  {
    self::$webhookUrl = $webhookUrl;

    set_error_handler(function (int $severity, string $message, string $file, int $line) {
      self::reportError("Error #{$severity}", "{$message} in {$file}:{$line}");
      return false;
    });

    set_exception_handler(function (\Throwable $e) {
      self::reportError('Unhandled Exception', "{$e->getMessage()}\n{$e->getTraceAsString()}");
    });

    echo "\x1b[32m[AntiCrash] Active\x1b[0m" . PHP_EOL;
  }

  public static function reportError(string $title, string $message): void
  {
    echo "\x1b[31m[AntiCrash] {$title}: {$message}\x1b[0m" . PHP_EOL;
    if (!empty(self::$webhookUrl)) {
      WebhookUtil::send(self::$webhookUrl, "**{$title}**\n```\n{$message}\n```");
    }
  }
}
