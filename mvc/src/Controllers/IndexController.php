<?php

namespace MyApp\Controllers;

use MyApp\Models\Goods;
use MyApp\Models\History;

class IndexController extends Controller
{
    //Экшн по умолчанию (если обратились к главной странице)
    public function actionIndex()
    {
        $goods = Goods::getAll();

        $this->render('index.twig', [
            'goods' => $goods,
        ]);

        if ($_SESSION['user']) {
            History::writeUserHistory($_SESSION['user']['id'], $_SERVER['REQUEST_URI']);
        }
    }

    public function actionError()
    {
        $this->render('error.twig');
    }
}
