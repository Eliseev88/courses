<?php

namespace MyApp\Models;

class Catalog extends Model
{
    const TABLE = 'category';

    public static function getCategoryById($id)
    {
        return self::db()->getById(self::TABLE, $id);
    }

    public static function getCategories()
    {
        return self::db()->getAllData(self::TABLE);
    }
}
