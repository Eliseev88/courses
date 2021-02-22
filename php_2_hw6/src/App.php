<?php

namespace MyApp;

use MyApp\Controllers\IndexController;
use MyApp\Traits\Singleton;
use MyApp\Models\History;

class App
{
    use Singleton;

    private $config;
    private $db;

    //Метод получения экзмепляра класса DB
    public function getDB(): DB
    {
        return $this->db;
    }

    public function run()
    {
        session_start();

        $path = $_SERVER['REQUEST_URI'];

        // Запускаем роутер
        $router = new Router($this->config['routing']);
        [$controllerName, $actionName, $param] = $router->parse($path);

        //Создаем экземпляр класса подулючения к БД
        $this->db = new DB($this->config['db']);

        if ($_SESSION['user']) {
            History::writeUserHistory($_SESSION['user']['id'], $path);
        }

        //Разбиваем путь на конроллер, экшн и параметры
        //ex1: /cont/act/123?foo=bar
        //ex2: /cont/act/123
        // /cont/act/123
        /*[$url] = explode('?', $path);
        $url = trim($url, '/');
        [$controllerName, $actionName, $param] = explode('/', $url);*/

        // //Определяем контроллер если ничего не запросили
        // if (empty($controllerName)) {
        //     $controllerName = 'index';
        // }
        // //Определяем экшен если его не запросили
        // if (empty($actionName)) {
        //     $actionName = 'index';
        // }

        //Формируем имя контроллера к которому будем обращаться
        $controllerClass = 'MyApp\Controllers\\' . ucfirst($controllerName) . 'Controller';
        //Имя метода
        $methodName = 'action' . ucfirst($actionName);

        //Проверка существует ли запрашиваемая страница
        if (class_exists($controllerClass)) {
            //Создаем нужный контроллер
            $controller = new $controllerClass();
            //Проверяем существует ли метод в созданном классе
            if (method_exists($controllerClass, $methodName)) {
                //Вызываем нужный метод c передачей $param
                $controller->$methodName($param);
                return;
            }
        }

        //Если запрашивения страница не существует
        (new IndexController())->actionError();
    }

    public function setConfig($config)
    {
        $this->config = $config;
        //Для вызова методов по цепочке
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}
