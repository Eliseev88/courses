<?php

namespace MyApp\php_classes;

use \PDO;
use \PDOException;
use \Exception;

class File 
{
    public function uploadImage(array $file)
    {
        // Проверяем файл на валидность
        if($file['name'] == '')
            return $_SESSION['msg'] = 'Вы не выбрали файл.';

        if($file['size'] > 999999)
            return $_SESSION['msg'] = 'Файл слишком большой.';

        $getMime = explode('.', $file['name']);
        $mime = strtolower(end($getMime));
        $types = ['jpg', 'png', 'gif', 'bmp', 'jpeg',];
        
        if(!in_array($mime, $types))
            return $_SESSION['msg'] = 'Недопустимый тип файла.';

        // Если валидность пройдена передаем файл на загрузку
        else $this->makeUpload($file);     
    }

    private function makeUpload($image)
    {
        // Формируем уникальное имя картинки и записываем в директорию
        $name = mt_rand(0, 10000) . $image['name'];
        copy($image['tmp_name'], './img/' . $name);

        // Передаем данные в БД
        $imgAddress = "'" . './img/' . $name . "'";
        $imgSize = $image['size'];
        $imgName = "'" . $image['name'] . "'";

        $this->uploadImgToDB($imgAddress, $imgSize, $imgName);
      }

    private function uploadImgToDB($imgAddress, $imgSize, $imgName)
    {
        try {
            $dbh = new PDO('mysql:dbname=gallery;host=127.0.0.1:3306', 'root', '123456');
            try {
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO images (address, size, name) VALUES ($imgAddress, $imgSize, $imgName);";
                $dbh->query($sql);
                unset($dbh);
                return $_SESSION['msg'] = "Изображение успешно загружено";
            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }
        } catch (PDOException $e) {
            die ('Error: Could not connect. ' . $e->getMessage());
        }  
    }
}
