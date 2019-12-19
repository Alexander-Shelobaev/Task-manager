<?php

namespace app\controllers;

use app\core\Controller;
//use app\core\Db;

class MigrationController extends Controller
{
    public function indexAction()
    {
        $this->model->createTable();
        $_SESSION['success'] = 'Создание таблицы прошло успешно';
        $this->view->redirect('/');
    }
}
