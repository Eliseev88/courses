<?php

namespace MyApp\Models;

class Goods extends Model
{
    const TABLE = 'products';

    public static function getAll()
    {
        return self::db()->getAllData(self::TABLE);
    }

    public static function getPart($start, $limit)
    {
        return self::db()->getPart(self::TABLE, $start, $limit);
    }

    public static function add($name, $price)
    {
        //Делаем подготовленные данные
        $stmt = self::link()->prepare('INSERT INTO ' . self::TABLE . " SET name = :name, price = :price ");
        $stmt->bindParam(':name', $name, \PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
