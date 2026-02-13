<?php

class Autoload
{
    public static function autoload($className)
    {
        require_once ROOT_PATH . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className . '.php');
    }
}
spl_autoload_register(['Autoload', 'autoload']);
