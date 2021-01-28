<?php

namespace MyApp\php_classes;

use MyApp\traits\Singleton as SingletonDB;
use \PDO;
use \PDOException;
use \Exception;

final class DB
{
    public const TABLE_GOODS = 'goods';

    private $link;
    private static $config = [
        'dsn' => 'mysql:dbname=catalog;host=127.0.0.1:3306',
        'user' => 'root',
        'pwd' => '123456',
    ];
    
    use SingletonDB;

    private function __construct()
	{
        try {
            $this->link = new PDO(
                self::$config['dsn'],
                self::$config['user'],
                self::$config['pwd']
            );
        } catch (PDOException $e) {
            die ('Error: Could not connect. ' . $e->getMessage());
        }
        
    }

    public function getRowCount($tableName)
    {
        try {
            return $this->link
                ->query("SELECT * FROM " . $tableName . ";")
                ->rowCount();
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    public function getCatalog($tableName, $offset)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query("SELECT * FROM " . $tableName . " LIMIT 8 OFFSET " . $offset . ";")
                ->fetchAll( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}
