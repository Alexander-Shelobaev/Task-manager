<?php

namespace app\core;

use app\core\Db;

abstract class Model
{

    static $db = null;
    
    /**
     * Подключает класс для работы с БД
     * используя паттерн Singleton
     */
    public function __construct()
    {
        if (self::$db != null) {
            return self::$db;
        }
        return self::$db = new Db();
    }

    /**
     * Одиночки не должны быть клонируемыми.
     */
    protected function __clone()
    {

    }

    /**
     * Одиночки не должны быть восстанавливаемыми из строк.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

}
