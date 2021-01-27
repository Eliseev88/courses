<?php
namespace MyApp\php_classes;

use MyApp\interfaces\GalleryInterface;
use \PDO;
use \PDOException;
use \Exception;

class Gallery implements GalleryInterface
{   
    static $uploadError;
    static $dbRespond;
    private $data;

    public function getGallery(): void
    {   
        try {
            $dbh = new PDO('mysql:dbname=gallery;host=127.0.0.1:3306', 'root', '123456');
            try {
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT id, address FROM images ORDER BY id DESC;";
                $sth = $dbh->query($sql);
                while ($row = $sth->fetch( PDO::FETCH_ASSOC )) {
                    $this->data[] = $row;
                }
                $this->renderTwig();
                unset($dbh);
            } catch (Exception $e) {
                die ('ERROR: ' . $e->getMessage());
            }
        } catch (PDOException $e) {
            die ('Error: Could not connect. ' . $e->getMessage());
        }
    }

    private function renderTwig()
    {
        $loader = new \Twig\Loader\FilesystemLoader('./templates');
        $twig = new \Twig\Environment($loader);
        echo $twig->render('gallery.twig', [
            'titleGallery' => 'Галлерея изображений',
            'dbRespond' => $_SESSION['msg'],
            'gallery' => $this->data,
        ]);
        $_SESSION['msg'] = '';
    }

}
