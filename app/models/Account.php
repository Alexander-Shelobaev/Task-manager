<?php

namespace app\models;

use app\core\Model;

class Account extends Model
{

    public function selectUser($params)
    {
        $result = self::$db->row(
            'SELECT login, email, password, active FROM users WHERE login = :login', $params
        );
        return $result;
    }

    public function selectEmail($params)
    {
        $result = self::$db->row(
            'SELECT login, email, password FROM users WHERE email = :email', $params
        );
        return $result;
    }

    public function createUser($params)
    {
        $result = self::$db->query(
            'INSERT INTO users (login, email, password, active_key, active, name)
                        VALUES (:login, :email, :password, :active_key, :active, :name)', $params
        );
        return $result;
    }

    public function activeUser($params)
    {
        $result = self::$db->query(
            'UPDATE users SET active = :active WHERE active_key = :active_key', $params
        );
        return $result;
    }

    public function resetPasswordUser($params)
    {
        $result = self::$db->query(
            'UPDATE users SET password = :password WHERE email = :email', $params
        );
        return $result;
    }

    public function createRole($params)
    {
        $result = self::$db->query(
            'INSERT INTO roles (name, code)
                        VALUES (:name, :code)', $params
        );
        return $result;
    }

    public function createPermission($params)
    {
        $result = self::$db->query(
            'INSERT INTO permissions (name, code)
                        VALUES (:name, :code)', $params
        );
        return $result;
    }

    public function createRoleUser($params)
    {
        $result = self::$db->query(
            'INSERT INTO role_user (user_id, role_id)
                        VALUES (:user_id, :role_id)', $params
        );
        return $result;
    }

    public function createUserPermission($params)
    {
        $result = self::$db->query(
            'INSERT INTO permission_role (role_id, permission_id)
                        VALUES (:role_id, :permission_id)', $params
        );
        return $result;
    }

    public function getUserPermission($params)
    {
        $result = self::$db->rows(
            'SELECT DISTINCT permissions.code 
             FROM users
             INNER JOIN role_user ON users.id = role_user.user_id
             INNER JOIN roles ON role_user.role_id = roles.id
             INNER JOIN permission_role ON roles.id = permission_role.role_id
             INNER JOIN permissions ON permission_role.permission_id = permissions.id
             WHERE login = :login
             ', $params
        );
        return $result;
    }

}
