<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller
{

    public function indexAction()
    {
        // Устанавливаем заголовок страницы
        $title = 'Главная | Task manager';
        // Устанавливаем путь к виду
        // $this->view->path = '';
        // Устанавливаем имя шаблона
        $this->view->layout = 'basic-admin-dashboard';
        // Отрисовываем страницу
        $this->view->render($title);
    }

}
