<?php
session_start();

require_once './vendor/autoload.php';
require './traits/Singleton.php';
require_once './php_classes/DB.php';

use MyApp\php_classes\DB;

$productsToShow = 0;

$catalog = DB::getInstance()->getCatalog(DB::TABLE_GOODS, $productsToShow);
$loader = new \Twig\Loader\FilesystemLoader('./templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('catalog.twig', [
    'catalog' => $catalog,
]);

include ('./js/ajax.js');
