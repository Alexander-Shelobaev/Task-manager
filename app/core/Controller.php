<?php

namespace app\core;

use app\core\View;

abstract class Controller
{
    
    public $route_params;
    public $view;

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
        $this->view = new View($route_params);
        $this->model = $this->loadModel($route_params['controller']);
    }

    public function loadModel($name)
    {
        $path = 'app\models\\'.ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }

}
