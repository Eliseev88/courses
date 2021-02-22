<?php

namespace MyApp\Controllers;

use MyApp\Models\Goods;

class IndexController extends Controller
{
    //Экшн по умолчанию (если обратились к главной странице)
    public function actionIndex()
    {
        $goods = Goods::getPart(1, 8);

        $this->render('index.twig', [
            'goods' => $goods,
        ]);
    }

    public function actionError()
    {
        $this->render('error.twig');
    }
}
