<?php
session_start();

require '../traits/Singleton.php';
require_once '../php_classes/DB.php';

use MyApp\php_classes\DB;

$offset = $_POST['offset'];

$catalog = DB::getInstance()->getCatalog(DB::TABLE_GOODS, $offset);

$html = "";
foreach ($catalog as $item) {
    $html .= "
            <div class=\"catalog__item\">
                <button name=\"add\" class=\"catalog__bucket fas fa-cart-arrow-down\">Add to Cart</button>
                <div class=\"catalog__photo\">
                    <img class=\"catalog__img\" src=\"{$item['image']}\" alt=\"#\">
                </div>
                <div class=\"catalog__content\">
                    <a class=\"catalog__name\" href=\"single.html\">{$item['name']}</a>
                    <div class=\"catalog__price\">\${$item['price']}</div>
                </div>
            </div>
        ";
}
echo $html;
