<?php

namespace MyApp\php_classes;

require './traits/Singleton.php';

use MyApp\traits\Singleton as SingletonTrait;

final class Singleton
{
    use SingletonTrait;

    public function getInfo()
    {
        echo get_class($this), PHP_EOL;
    }
}
