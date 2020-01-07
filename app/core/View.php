<?php

namespace app\core;

class View
{
    
    public $route_params;
    public $path;
    public $layout = 'default';

    public function __construct($route_params)
    {
        // Сохраняем массив параметров роута
        $this->route_params = $route_params;
        // Формируем путь к виду
        $this->path = $route_params['controller'] . '/' . $route_params['action'];
    }

    /**
     * Формирует и выводит страницу
     */
    public function render($title, $vars = [])
    {
        // Распаковываем массив в переменные
        extract($vars);
        // Формируем путь к шаблону 
        $layout = 'app/views/layouts/' . $this->layout . '.php';
        if (!file_exists($layout)) {
            View::errorCode(404, "Не найден шаблон $layout <br>Сообщите администратору сайта.");
        }
        // Формируем путь к виду
        $path = 'app/views/' . $this->path . '.php';
        if (file_exists($path)) {
            // Включаем буферизацию
            ob_start();
            // Подключаем вид
            include_once $path;
            // Выключаем буферизация и выгружаем
            // данные в переменную $content
            $content = ob_get_clean();
            // Подключаем шаблон
            include_once $layout;
        } else {
            View::errorCode(404, "Не найден вид $path <br>Сообщите администратору сайта.");
        }
    }

    /**
     * Выводит страницы с ошибками (например: страницу 404)
     */
    public static function errorCode($code = 404, $text = 'Извините! Произошла ошибка.')
    {
        http_response_code($code);
        $path = 'app/views/errors/page-error.php';
        include_once $path;
        exit;
    }

    /**
     * Завершает работу и отправляет статус и сообщение
     */
    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    /**
     * Выполняет редирект
     */
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }

}
