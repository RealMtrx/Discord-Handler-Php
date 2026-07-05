<?php

namespace DiscordHandler\models;

use DiscordHandler\database\Mongo;

class UserModel
{
  private const COLLECTION = 'users';

  public static function find(string $userId): ?array
  {
    if (!Mongo::isConnected()) return null;
    return Mongo::getClient()
      ->selectDatabase('discord-handler')
      ->selectCollection(self::COLLECTION)
      ->findOne(['user_id' => $userId]);
  }

  public static function upsert(string $userId, array $data = []): void
  {
    if (!Mongo::isConnected()) return;
    Mongo::getClient()
      ->selectDatabase('discord-handler')
      ->selectCollection(self::COLLECTION)
      ->updateOne(
        ['user_id' => $userId],
        ['$set' => array_merge($data, ['updated_at' => new \MongoDB\Model\UTCDateTime()])],
        ['upsert' => true]
      );
  }
}
