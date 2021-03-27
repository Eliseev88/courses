<?php

return [
    'db' => [
        'dsn' => 'mysql:dbname=store;host=127.0.0.1:3306',
        'user' => 'root',
        'pwd' => '123456',
    ],
    'templates' => __DIR__ . '/../templates',
    'routing' => [
        'signin' => 'account/signin',
        'signup' => 'account/signup',
        'logout' => 'account/logout',
        'basket' => 'account/basket',
        'clear'  => 'account/clear',
        'order'  => 'account/order',
        'catalog\/([0-9]+)\/([0-9]+)' => 'catalog/good',
        'catalog\/([0-9]+)' => 'catalog/category',
        'catalog' => 'catalog/index',
        '(\w+)\/(\w+)' => '<controller>/<action>',
        '(\w+)' => '<controller>/index',
        '^$' => 'index/index',
        '(.*)' => 'index/error',
    ],
];
