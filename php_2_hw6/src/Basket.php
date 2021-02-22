<?php

namespace MyApp;

use MyApp\Models\Goods;

class Basket
{
    public static function get()
    {
        self::init();

        return $_SESSION['basket'];
    }

    public static function add($id)
    {
        self::init();

        $_SESSION['basket']['count']++;
        $_SESSION['basket']['goods'][$id]++;
    }

    public static function clear()
    {
        self::init(true);
    }

    public static function getAllBasketGoods()
    {
        $cart = self::get();

        $basket = [
            'goods' => [],
            'sum' => 0,
        ];

        foreach ($cart['goods'] as $id => $count) {
            $good = Goods::getById($id);
            $good['count'] = $count;
            $basket['goods'][] = $good;
            $basket['sum'] += $count * $good['price'];
        }

        return $basket;
    }

    private static function init($force = false)
    {
        if ($force || empty($_SESSION['basket'])) {
            $_SESSION['basket'] = [
                'count' => 0,
                'goods' => [],
            ];
        }
    }
}
