<?php 

namespace MyApp\php_classes\classes_for_2nd_hw;

use MyApp\php_classes\Product;

class DigitalProduct extends Product
{   
    public function getFinalCost(): void
    {
        echo "Стоимость цифрового товара " . self::$price / 2 . " рублей <br>";
    }
}
