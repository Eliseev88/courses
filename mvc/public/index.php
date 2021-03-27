<?php

session_start();

//Отключаем Notice
error_reporting(E_ALL & ~E_NOTICE);

require '../vendor/autoload.php';
require '../config/main.php';

\MyApp\App::getInstance()
    ->setConfig(require '../config/main.php')
    ->run();
