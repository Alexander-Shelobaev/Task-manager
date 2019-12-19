<?php

namespace app\models;

use app\models\Account;

trait Gate
{

    public $gate;
    
    public function accessCheck($codePermissions)
    {
        if (!isset($_SESSION['logged_user']['login'])) {
            return true;
        }

        $this->gate = new Account();
        $params = ['login' => $_SESSION['logged_user']['login']];
        $res = $this->gate->getUserPermission($params);
        $codePermissions = array_unique($codePermissions);
        $perm_code_arr = [];
        foreach ($res as $key => $value) {
            $perm_code_arr[] = $value['code'];
        }
        $array_intersect = array_intersect($codePermissions, $perm_code_arr);
        if (count($codePermissions) === count($array_intersect)) {
            return false;
        }
        return true;
    }

}
