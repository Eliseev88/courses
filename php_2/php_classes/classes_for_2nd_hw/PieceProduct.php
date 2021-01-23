<?php 

namespace MyApp\php_classes\classes_for_2nd_hw;

use MyApp\php_classes\Product;
    
class PieceProduct extends Product
{
    public function getFinalCost(): void
    {
        echo "Стоимость штучного товара " . self::$price . " рублей <br>";
    }
}
