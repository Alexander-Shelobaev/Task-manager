<?php

namespace app\core;

use app\core\Db;

abstract class Model
{

    static $db = null;
    
    public function __construct()
    {
        if (self::$db != null) {
            return self::$db;
        }
        return self::$db = new Db();
    }

}
