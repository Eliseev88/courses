<?php

namespace MyApp\php_classes;

require './interfaces/ProductInterface.php';

use MyApp\interfaces\ProductInterface;

abstract class Product implements ProductInterface
{
    abstract public function getFinalCost(): void;

    protected static $price = 100;

    public function setProductName(string $name): void
    {   
        $this->name = $name;
    }

    public function setProductPrice(int $price): void
    {
        self::$price = $price;
    }
}
