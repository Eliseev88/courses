<?php

namespace MyApp\Models;

use MyApp\Models\Model;

class Orders extends Model
{
    const STATUS_NEW = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_REJECTED = 3;
    const STATUS_DONE = 4;

    const TABLE_ORDER = 'order';
    const TABLE_ORDER_PRODUCTS = 'order_products';

    private static $statuses = [
        self::STATUS_NEW => 'New',
        self::STATUS_PROGRESS => 'In progress',
        self::STATUS_REJECTED => 'Rejected',
        self::STATUS_DONE => 'Finished',
    ];

    // Отображение всех заказов
    public static function getAll()
    {
        $rows = self::link()->query('
            SELECT order.id, date, status, product_id, count, order_products.price, 
            category_id, products.name, login FROM store.order 
            JOIN store.order_products ON order.id = order_id 
            JOIN store.products ON product_id = products.id 
            JOIN store.users ON order.user_id = id_user 
            ORDER BY order.id DESC;
        ')->fetchAll(\PDO::FETCH_ASSOC);

        $orders = [];
        foreach ($rows as $row) {
            $id = $row['id'];

            // Если id товавра еще нет, то создаем
            if (!isset($orders[$id])) {
                $orders[$id] = [
                    'id' => $id,
                    'date' => $row['date'],
                    'status' => $row['status'],
                    'login' => $row['login'],
                    'sum' => 0,
                    'goods' => [],
                ];
            }

            // Если есть, то добавляем товары

            $orders[$id]['goods'][] = [
                'id' => $row['product_id'],
                'name' => $row['name'],
                'categoryId' => $row['category_id'],
                'count' => $row['count'],
                'price' => $row['price'],
                'sum' => $row['count'] * $row['price'],
            ];
            $orders[$id]['sum'] += $row['count'] * $row['price'];
        }
        return $orders;
    }

    // Метод добавления заказа
    public static function add($userId, $goodsCounts): int
    {
        self::link()->exec(
            'INSERT INTO store.' . self::TABLE_ORDER  
            . ' SET user_id = ' . (int)$userId 
            . ', status = ' . self::STATUS_NEW
        );
        
        $orderId = self::link()->lastInsertId();

        foreach ($goodsCounts as $id => $count) {
            $good = Goods::getById($id);

            self::link()->exec(
                'INSERT INTO ' . self::TABLE_ORDER_PRODUCTS 
                . ' SET order_id = ' . $orderId 
                . ', product_id = ' . (int)$id
                . ', count = ' . (int)$count
                . ', user_Id =' . (int)$userId
                . ', price = ' . $good['price']
            );
        }
        return $orderId;
    }

    // Метод получения статусов
    public static function getStatuses()
    {
        return self::$statuses;
    }


    // Метод изменения статуса заказа
    public static function setStatus($id, $status)
    {
        if (!isset(self::$statuses[$status])) {
            return;
        }

        self::link()->exec(
            'UPDATE store.' . self::TABLE_ORDER . ' SET status=' . (int)$status . ' WHERE id=' . (int)$id
        );
    }
}