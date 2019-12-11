<?php

require_once 'app/config/env.php';

use app\core\Router;

spl_autoload_register(
    function ($class) {
        $path = str_replace('\\', '/', $class.'.php');
        if (file_exists($path)) {
            include_once $path;
        }
    }
);

session_start();

$router = new Router;
$router->run();
