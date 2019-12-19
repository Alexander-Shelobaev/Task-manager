<?php

namespace app\models;

use app\core\Model;

class Migration extends Model
{
    public function createTable()
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
            $migration = include_once $path . $value;
            $result = self::$db->query($migration);
        }
        return $result;
    }
}
