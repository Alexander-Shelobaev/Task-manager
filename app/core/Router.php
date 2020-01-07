<?php

namespace app\core;

use app\core\View;

class Router
{
    
    protected $routes = [];
    protected $params = [];
    
    public function __construct()
    {
        // Загружаем список роутов
        $routes = include_once 'app/config/routes.php';
        foreach ($routes as $key => $value) {
            $this->add($key, $value);
        }
    }

    /**
     * Загружает и подготавливает роуты
     */
    public function add($route, $params)
    {
        // С помощью регулярного выражения изменяем вид роута
        // подготавливая роут для функции проверки - match()
        // также использовуем именованные подмаски
        // tasks/edit/{id:\d+} => tasks/edit/(?<id>\d+)
        // в подмасках будет храниться параметр маршрута,
        // например параметр id и его значение 4
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?<\1>\2)', $route);
        $route = '#^'.$route.'$#';
        $this->routes[$route] = $params;
    }

    /**
     * Проверяет соответствие роута и маршрута указанного в url
     */
    public function match()
    {
        // Получаем запрос клиекта
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            // Ищим соответствие между
            // роутом #^tasks/edit/(?<id>\d+)$#
            // и url /tasks/edit/4
            // в $matches попадают совпадения
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        if (is_numeric($match)) {
                            $match = (int)$match;
                        }
                        $params[$key] = $match;
                    }
                }
                // Сохраняем параметр маршрута
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Вызывает метод контролера, который соответствует маршруту
     */
    public function run()
    {
        if ($this->match()) {
            $path = 'app\controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'] . 'Action';
                if (method_exists($path, $action)) {
                    // Загружаем контролер
                    $controller = new $path($this->params);
                    // Вызываем метод
                    $controller->$action();
                } else {
                    // Не найден метод контролера
                    View::errorCode(404, 'Не найден метод контролера. Сообщите администратору сайта.');
                }
            } else {
                // Не найден контролер
                View::errorCode(404, 'Не найден контролер. Сообщите администратору сайта.');
            }
        } else {
            // Не найден маршрут
            View::errorCode(
                404,
                'Извините! Эта страница не существует.<br>
                Вами был неправильно набран адрес, или такой страницы не существует.'
            );
        }
    }

}
