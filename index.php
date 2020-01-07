<?php
/**
 * Файл является точкой входа данного MVC приложения
 */

// Загружаем настройки среды разработки
require_once 'app/config/env.php';

// Реализуем автозагрузку классов
spl_autoload_register(
    function ($classname) {
        $path = __DIR__ . "/$classname.php";
        if (file_exists($path)) {
            include_once $path;
        }
    }
);

// Запускаем сессии
session_start();

// Запускаем роутер
$router = new app\core\Router;
$router->run();
