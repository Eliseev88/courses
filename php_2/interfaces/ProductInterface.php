<?php 

namespace MyApp\interfaces;

interface ProductInterface
{
    public function setProductName(string $name): void;
    public function setProductPrice(int $price): void;
}