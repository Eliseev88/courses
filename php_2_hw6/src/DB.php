<?php

namespace MyApp;

use \PDO;
use \PDOException;
use \Exception;

final class DB
{
    private $link;

    public function getLink(): \PDO
    {
        return $this->link;
    }

    public function __construct($config)
	{
        try {
            $this->link = new PDO(
                $config['dsn'],
                $config['user'],
                $config['pwd']
            );
        } catch (PDOException $e) {
            die ('Error: Could not connect. ' . $e->getMessage());
        }
        
    }

    // Метод подсчета строк
    public function getCount($tableName)
    {
        return $this->link
            ->query("SELECT COUNT(*) FROM {$tableName}")
            ->fetchColumn();
    }

    // Метод получения определенного числа товаров
    public function getPart($tableName, int $start, int $limit)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query("SELECT * FROM {$tableName} LIMIT {$start},{$limit}")
                ->fetchAll( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    // Метод получения всех товаров
    public function getAllData($tableName)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query("SELECT * FROM {$tableName}")
                ->fetchAll( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    // Получение по id
    public function getByid($tableName, $id)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query("SELECT * FROM {$tableName} WHERE id = " . (int)$id)
                ->fetch( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    // Метод получения куки-токена
    public function getCookie($tableName, $userCookieToken)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query("SELECT * FROM {$tableName} WHERE cookie_token = '" . $userCookieToken . "'")
                ->fetchAll( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }

    // Метод получения пользователя
    public function getUser($tableName, $userLogin)
    {
        $stmt = $this->link->prepare(' SELECT * FROM ' . $tableName . " WHERE login = :login LIMIT 1 ");
        $stmt->bindParam(':login', $userLogin, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll( PDO::FETCH_ASSOC );
    }

    // Метод получения истории посещений
    public function getHistory($tableName, $userId)
    {
        try {
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->link
                ->query
                    (
                        "SELECT page FROM {$tableName} WHERE user_id = {$userId} 
                        ORDER BY id DESC LIMIT 5"
                    )
                ->fetchAll( PDO::FETCH_ASSOC );
        } catch (Exception $e) {
            die ('ERROR: ' . $e->getMessage());
        }
    }
}
