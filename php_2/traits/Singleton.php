<?php

namespace MyApp\traits;

trait Singleton
{
    private static $instance;

    public static function getInstance()
    {
        if(empty(self::$instance)) self::$instance = new self();

        return self::$instance;
    }

	private function __clone()
	{
    }
    
	private function __wakeup()
	{
	}
}
