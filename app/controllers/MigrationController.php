<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Db;

class MigrationController extends Controller
{

    static $db = null;
    public function __construct()
    {
        if (self::$db != null) {
            return self::$db;
        }
        return self::$db = new Db();
    }


    public function indexAction()
    {

        $path = 'app/database/migrations/';
        $migrations = scandir($path);
        foreach ($migrations as $key => $value) {
            if ($value == '.') {
                continue;
            }
            if ($value == '..') {
                continue;
            }

            $migration = include_once $path.$value;
            $result = self::$db->query($migration);
            if (!$result) {
                $_SESSION['error'] = 'Ошибка при создании таблицы';
                header("Location: /");
                exit;
            }

        }

        $_SESSION['success'] = 'Создание таблицы прошло успешно';
        header("Location: /");
        exit;
        
    }

}
