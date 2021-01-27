<?php
namespace MyApp\php_classes;

use \PDO;
use \PDOException;
use \Exception;

class CurrentImage
{
    public function __construct(string $imageId)
    {
        if($imageId && is_numeric($imageId)){
            try {
                $dbh = new PDO('mysql:dbname=gallery;host=127.0.0.1:3306', 'root', '123456');
                try {
                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "SELECT address, name FROM images WHERE id = $imageId;";
                    $sth = $dbh->query($sql);
                    $row = $sth->fetch( PDO::FETCH_ASSOC );
                    $this->renderImage($row['address'], $row['name']);
                    unset($dbh);
                } catch (Exception $e) {
                    die ('ERROR: ' . $e->getMessage());
                }
            } catch (PDOException $e) {
                die ('Error: Could not connect. ' . $e->getMessage());
            }
        }
    }
    private function renderImage($address, $name)
    {
        $loader = new \Twig\Loader\FilesystemLoader('./templates');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('images.twig', [
            'titleGallery' => $name,
            'address' => $address,
        ]);
    }
}
