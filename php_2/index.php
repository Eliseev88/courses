<?php 

//1. Придумать класс, который описывает любую сущность из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.

require_once './php_classes/Price.php';
require_once './php_classes/SpecialPrice.php';

$productPrice1 = new Price(545, 10, 'рублей');

echo $productPrice1->getFinalCost() . " " . $productPrice1->currency . "<br>";

$specialProductPrice1 = new SpecialPrice(545, 10, '$', 5);

echo $specialProductPrice1->getFinalCost() . " " . $specialProductPrice1->currency . "<br>";

$productPrice1->getCurrencyExchange();

echo 'Tекущий курс обмен валюты: ' . Price::currencyExchange;

// Дан код:

class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A();
$a2 = new A();
$a1->foo(); // 1 потому что pre инкремент
$a2->foo(); // 2 т.к. static накапливает в себе
$a1->foo(); // 3
$a2->foo(); // 4

// Изменим код: 

class B extends A {
}
$a1 = new A();
$b1 = new B();
$a1->foo(); // 5
$b1->foo(); // т.к. класс B имеет свой static 
$a1->foo(); // 6
$b1->foo(); // 2

// Дан код :

$a1 = new A;
$b1 = new B;
$a1->foo(); // 7
$b1->foo(); // 3
$a1->foo(); // 8
$b1->foo(); // 4