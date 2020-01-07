<?php

namespace app\core;

use app\core\View;

abstract class Controller
{
    
    public $route_params;
    public $view;

    public function __construct($route_params)
    {
        // Сохраняем массив параметров роута
        $this->route_params = $route_params;
        // Создаем вид
        $this->view = new View($route_params);
        // Создаем модель
        $this->model = $this->loadModel($route_params['controller']);
    }

    /**
     * Создает модель
     */
    public function loadModel($name)
    {
        $modelName = 'app\models\\' . ucfirst($name);
        if (class_exists($modelName)) {
            $path = $modelName . '.php';
            if (file_exists($path)) {
                return new $modelName;
            }
        }
    }

}
