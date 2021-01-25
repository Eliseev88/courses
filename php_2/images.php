<?php
session_start();

require_once './vendor/autoload.php';
require_once './interfaces/GalleryInterface.php';
include './php_classes/CurrentImage.php';
    
use MyApp\php_classes\CurrentImage;

$currentImage = new CurrentImage($_GET['image']);
