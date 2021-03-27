<?php

namespace MyApp\Models;

class History extends Model
{
    const TABLE = 'history';

    public static function getUserHistory($userId)
    {
        return self::db()->getHistory(self::TABLE, $userId);
    }

    public static function writeUserHistory($userId, $page)
    {
        $stmt = self::link()->prepare
                (
                    'INSERT INTO ' . self::TABLE . " (page, user_id) VALUES (:page, :userId) "
                );
        $stmt->bindParam(':page', $page, \PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
