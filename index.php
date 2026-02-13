<?php

define('ROOT_PATH', __DIR__);

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
define('ROOT_URL', $scheme . '://' . $host . ($base ? $base . '/' : '/'));

require_once ROOT_PATH . '/Core/Autoload.php';

$router = new Core\Router;
$router->route();
