<?php

namespace MyApp\php_classes;

use MyApp\php_classes\classes_for_2nd_hw\DigitalProduct;
use MyApp\php_classes\classes_for_2nd_hw\PieceProduct;
use MyApp\php_classes\classes_for_2nd_hw\WeightProduct;
use MyApp\interfaces\ProductInterface;

class ProductFactory
{   
    const TYPE_DIGITAL = 'цифровой';
    const TYPE_PIECE = 'штучный';
    const TYPE_WEIGHT = 'весовой';

    public static function getProductType($type) : ProductInterface
    {
        switch($type) {
            case self::TYPE_DIGITAL:
                return new DigitalProduct();
            case self::TYPE_PIECE:
                return new PieceProduct();
            case self::TYPE_WEIGHT:
                return new WeightProduct();
        }
    }     
}
    