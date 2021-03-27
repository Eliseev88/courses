<?php

namespace MyApp\Controllers;

use MyApp\Models\Goods;
use MyApp\Models\Catalog;

class GoodsController extends Controller
{
    //Экшн каталога товаров (если обратились к каталогу)
    public function actionIndex()
    {
        $goods = Goods::getPart(8, 9);

        $categories = Catalog::getCategories();

        $this->render('goods.twig', [
            'goods' => $goods,
            'categories' => $categories,
        ]);
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
