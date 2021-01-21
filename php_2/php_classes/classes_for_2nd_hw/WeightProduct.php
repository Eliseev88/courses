<?php 

namespace MyApp\php_classes\classes_for_2nd_hw;

use MyApp\php_classes\Product;

class WeightProduct extends Product
{
    private $weight;

    public function setWeight (int $weight ) : void
    {
        $this->weight = $weight;
    }

    public function getFinalCost(): void
    {
        echo "Стоимость товара на развес " . self::$price * $this->weight . " рублей <br>";
    }
}
