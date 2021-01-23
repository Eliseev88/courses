<?php

/*    
1. Создать структуру классов ведения товарной номенклатуры.
    а) Есть абстрактный товар.
    б) Есть цифровой товар, штучный физический товар и товар на вес.
    в) У каждого есть метод подсчета финальной стоимости.
    г) У цифрового товара стоимость постоянная – дешевле штучного товара в два раза. У штучного товара обычная стоимость, у весового – в зависимости от продаваемого количества в килограммах. У всех формируется в конечном итоге доход с продаж.
    д) Что можно вынести в абстрактный класс, наследование?
*/

use MyApp\php_classes\ProductFactory;

require './php_classes/ProductFactory.php';
require './php_classes/Product.php';
require './php_classes/classes_for_2nd_hw/DigitalProduct.php';
require './php_classes/classes_for_2nd_hw/PieceProduct.php';
require './php_classes/classes_for_2nd_hw/WeightProduct.php';

$digitalProduct1 = ProductFactory::getProductType(ProductFactory::TYPE_DIGITAL);
$pieceProduct1 = ProductFactory::getProductType(ProductFactory::TYPE_PIECE);
$weightProduct1 = ProductFactory::getProductType(ProductFactory::TYPE_WEIGHT);

$weightProduct1->setWeight(5);

$digitalProduct1->getFinalCost();
$pieceProduct1->getFinalCost();
$weightProduct1->getFinalCost();

// 2. *Реализовать паттерн Singleton при помощи traits

require './php_classes/Singleton.php';

use MyApp\php_classes\Singleton;

$Singleton = Singleton::getInstance();
$Singleton->getInfo();
