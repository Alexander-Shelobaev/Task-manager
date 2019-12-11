<?php

namespace app\core;

class View
{
    
    public $route_params;
    public $path;
    public $layout = 'default';

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
        $this->path = $route_params['controller'].'/'.$route_params['action'];
    }

    public function render($title, $vars = [])
    {
        extract($vars);
        $layout = 'app/views/layouts/'.$this->layout.'.php';
        if (!file_exists($layout)) {
            echo "Не найден шаблон $layout";
            exit;
        }
        $path = 'app/views/'.$this->path.'.php';
        if (file_exists($path)) {
            ob_start();
            include_once $path;
            $content = ob_get_clean();
            include_once $layout;
        } else {
            echo "Не найден вид $path";
            exit;
        }
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'app/views/errors/'.$code.'.php';
        if (file_exists($path)) {
            include_once $path;
        } else {
            echo "Не найден вид $path";
            exit;
        }
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    public function redirect($url)
    {
        header('location: '.$url);
        exit;
    }

}
