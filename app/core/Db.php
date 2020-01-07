<?php

namespace app\core;

use PDO;

class Db
{

    protected $dbh;
    
    /**
     * Выполняет соединение с БД
     */
    public function __construct()
    {
        try {
            // Устанавливаем соединение с БД
            $this->dbh = new PDO(
                'mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD
            );
            // Устанавливаем режим вывода ошибок
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, DB_ERRMODE);
        } catch (PDOException $e) {
            print "<br>Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }

    /**
     * Выполняет запрос к БД
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            if (!empty($params)) {
                foreach ($params as $key => $val) {
                    if (is_integer($val)) {
                        $stmt->bindValue(':' . $key, $val, PDO::PARAM_INT);
                    } else {
                        $stmt->bindValue(':' . $key, $val);
                    }
                }
            }
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            print "<br>Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }

    /**
     * Выполняет запрос к БД и возвращает ответ
     * в виде ассоциативного массива
     */
    public function rows($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Выполняет запрос к БД и возвращает ответ
     * в виде ассоциативного массива с одим элементом
     */
    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

}
