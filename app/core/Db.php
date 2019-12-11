<?php

namespace app\core;

use PDO;

class Db
{

    protected $dbh;
    
    public function __construct()
    {
        try {
            $config = include_once 'app/config/db.php';
            $this->dbh = new PDO(
                'mysql:host='.$config['HOST'].';dbname='.$config['DB_NAME'].'', 
                $config['DB_USER'], $config['PASSWORD']
            );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "<br>Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }

    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            if (!empty($params)) {
                foreach ($params as $key => $val) {
                    if (is_integer($val)) {
                        $stmt->bindValue(':'.$key, $val, PDO::PARAM_INT);
                    } else {
                        $stmt->bindValue(':'.$key, $val);
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

    public function rows($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function row($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

}
