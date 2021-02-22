<?php

namespace MyApp\Controllers;

use MyApp\Basket;
use MyApp\Models\Catalog;
use MyApp\Models\Goods;

class CatalogController extends Controller
{
    public function actionIndex()
    {
        $this->render('catalog/index.twig', [
            'categories' => Catalog::getCategories(),
        ]);
    }

    public function actionCategory($params)
    {
        //Получаем параметрр из урла, который будет является id категории
        $catId = array_shift($params);

        
        // Если не нашли по этому id в БД категорию
        if (!($category = Catalog::getCategoryById($catId))) {
            $this->redirect('/catalog');
        }

        // Если нашли
        $this->render('catalog/category.twig', [
            'goods' => Goods::getByCategory($catId),
            'category' => $category,
            'flagCat' => true,
        ]);
    }

    public function actionGood($params)
    {
        if (isset($_GET['add'])) {
            Basket::add($_GET['add']);
        }
                
        [$catId, $goodId] = $params;

        if (!($category = Catalog::getCategoryById($catId))) {
            $this->redirect('/catalog');
        }

        if (!($good = Goods::getById($goodId))) {
            $this->redirect('/catalog');
        }

        $recomends = Goods::getPart(1, 4);

        $this->render('catalog/good.twig', [
            'category' => $category,
            'good' => $good,
            'recomends' => $recomends,
            'extraClass' => true,
            'flagCat' => true,
            'flagGood' => true,
        ]);

    }

}
