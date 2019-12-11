<?php

namespace app\controllers;

use app\core\Controller;

class SeedController extends Controller
{

    public function indexAction()
    {
        // Список посевов
        $this->seed('account', '2019_12_08_1215_seedUsers', 'createUser');
        $this->seed('task', '2019_12_08_1216_seedTasks', 'createTask');
        $this->seed('account', '2019_12_08_1217_seedRoles', 'createRole');
        $this->seed('account', '2019_12_08_1218_seedPermissions', 'createPermission');
        $this->seed('account', '2019_12_08_1219_seedRoleUser', 'createRoleUser');
        $this->seed('account', '2019_12_08_1220_seedPermissionRole', 'createUserPermission');

        $_SESSION['success'] = 'Посев данных прошел успешно';
        header("Location: /");
        exit;
    }

    public function seed($name_model, $name_seed, $query_name)
    {
        // Загружаем модель
        $model = $this->loadModel($name_model);
        // Загружаем данные для посева
        $seed = include_once 'app/database/seeds/' . $name_seed . '.php';
        // Выполняем посев
        foreach ($seed as $key => $value) {
            $params = $value;
            $res = $model->$query_name($params);
            if (!$res) {
                $_SESSION['error'] = 'Ошибка при добавлении записи';
                header("Location: /");
                exit;
            }
        }
    }

}