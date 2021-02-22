<?php

namespace MyApp;

class Router
{
    private $config;

    public function __construct($config)
    {
         $this->config = $config;
    }

    public function parse($url)
    {
        $url = self::filter($url);

        foreach ($this->config as $pt => $route) {
            $pattern = '/' . $pt . '/u';
            if (!preg_match($pattern, $url, $matches)) {
                continue;
            }

            //Удаляем первый элемент в массиве
            array_shift($matches);

            [$controller, $action] = explode('/', $route);
            if ($controller === '<controller>') {
                $controller = array_shift($matches);
            }
            if ($action === '<action>') {
                $action = array_shift($matches);
            }

            return [$controller, $action, $matches];
        }

        return false;
    }

    private static function filter(string $url): string
    {
        // Удаляем лишнии слеши
        $parts =explode('/', $url);
        foreach ($parts as $key => $value) {
            if ($value == '') {
                unset($parts[$key]);
            }
        }

        return implode('/', $parts);
    }
}
