<?php
session_start();

require_once './vendor/autoload.php';
require_once './interfaces/GalleryInterface.php';
require_once './php_classes/Gallery.php';

use MyApp\php_classes\Gallery;

$gallery = new Gallery();

$gallery->getGallery();
