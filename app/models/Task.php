<?php

namespace app\models;

use app\core\Model;

class Task extends Model
{

    public function getTasks($params, $sort)
    {   
        $sql = "SELECT id as task_id, name, email, task_text, status, edited_by_admin FROM tasks";
        $sql .= " WHERE name LIKE :where OR email LIKE :where OR task_text LIKE :where OR status LIKE :where";
        $sort = explode('-', $sort);
        $sql .= " ORDER BY $sort[0] $sort[1]";
        //$sql .= " ORDER BY :sort_column :sort_key";
        $sql .= " LIMIT :from,:limit"; // int
        $result = self::$db->rows($sql, $params);
        return $result;
    }

    public function selectCountTasks($params)
    {
        $result = self::$db->row(
            'SELECT COUNT(*) as tasks FROM tasks WHERE name LIKE :where OR email LIKE :where OR task_text LIKE :where OR status LIKE :where', $params
        );
        return $result;
    }

    public function createTask($params)
    {
        $result = self::$db->query(
            'INSERT INTO tasks (name, email, task_text) VALUES (:name, :email, :task_text)', $params
        );
        return $result;
    }

    public function getTask($params)
    {
        $result = self::$db->row(
            'SELECT id as task_id, name as users_name, email as users_email, task_text, status, edited_by_admin
             FROM tasks WHERE id = :id', $params
        );
        return $result;
    }

    public function updateTask($params)
    {
        $result = self::$db->query(
            'UPDATE tasks SET task_text = :task_text, status = :status WHERE id = :id', $params
        );
        return $result;
    }

    public function updateTaskByAdmin($params)
    {
        $result = self::$db->query(
            'UPDATE tasks SET 
                    task_text = :task_text,
                    status = :status,
                    edited_by_admin = :edited_by_admin
                    WHERE id = :id', $params
        );
        return $result;
    }

    public function isTaskExists($params)
    {
        $result = self::$db->row(
            'SELECT id FROM tasks WHERE id = :id', $params
        );
        return $result;
    }

    public function taskDelete($params)
    {
        $result = self::$db->query(
            'DELETE FROM tasks WHERE id = :id', $params
        );
        return $result;
    }

}
