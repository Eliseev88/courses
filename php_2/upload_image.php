<?php
session_start();
require_once './interfaces/GalleryInterface.php';
require_once './php_classes/Gallery.php';
include './php_classes/File.php';
    
use MyApp\php_classes\File;

if(isset($_FILES['file'])){
    $image = new File();
    $image->uploadImage($_FILES['file']);
    header('Location: gallery.php');
}