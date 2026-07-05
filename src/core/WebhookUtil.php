<?php

namespace DiscordHandler\core;

class WebhookUtil
{
  public static function send(string $url, string $content, ?string $username = null, ?string $avatarUrl = null): void
  {
    if (empty($url)) return;

    $payload = ['content' => $content];
    if ($username) $payload['username'] = $username;
    if ($avatarUrl) $payload['avatar_url'] = $avatarUrl;

    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => json_encode($payload),
      CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_TIMEOUT => 5,
    ]);
    curl_exec($ch);
    curl_close($ch);
  }
}
