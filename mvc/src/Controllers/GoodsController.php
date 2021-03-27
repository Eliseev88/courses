<?php

namespace MyApp\Controllers;

use MyApp\Models\Goods;
use MyApp\Models\History;

class GoodsController extends Controller
{
    //Экшн каталога товаров (если обратились к каталогу)
    public function actionIndex()
    {
        $goods = Goods::getPart(8, 9);

        $this->render('goods.twig', [
            'goods' => $goods,
        ]);

        if ($_SESSION['user']) {
            History::writeUserHistory($_SESSION['user']['id'], $_SERVER['REQUEST_URI']);
        }
    }

    //Страница добавления товаров
    public function actionAdd()
    {
        //Метод добавления товара
        if (isset($_POST['name'])) {
            Goods::add($_POST['name'], $_POST['price']);
            $this->redirect();
        }

        $this->render('add.twig');
    }
}
