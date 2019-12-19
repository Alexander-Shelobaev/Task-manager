<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Gate;

class TaskController extends Controller
{

    use Gate;

    /**
     * Выводит список всех задач
     */
    public function indexAction()
    {
        // Проверяем полученные данные от пользователя
        $sort = isset($_GET["sort"]) ? strip_tags(trim($_GET["sort"])) : 'id-asc';
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $limit = isset($_GET["limit"]) ? (int)$_GET["limit"] : 10;
        $where = isset($_GET["where"]) ? '%' . strip_tags(trim($_GET["where"])) . '%' : '%%';
        
        // Формируем параметры для запроса в БД
        $from = ($page - 1) * $limit;
        $params = ['where' => $where, 'from' => $from, 'limit' => $limit];

        // Выполняем запрос к БД
        $task_list = $this->model->getTasks($params, $sort);

        // Формируем параметры для сортировки по возрастания и по убыванию
        $sort_name = (isset($_GET["sort"]) and $_GET["sort"] === 'name-asc') ? 'sort=name-desc' : 'sort=name-asc';
        $sort_email = (isset($_GET["sort"]) and $_GET["sort"] === 'email-asc') ? 'sort=email-desc' : 'sort=email-asc';
        $sort_status = (isset($_GET["sort"]) and $_GET["sort"] === 'status-asc')?'sort=status-desc':'sort=status-asc';

        // Обрабарываем данные из get запроса
        $pagination_last_url = '';
        $limit_last_url = '';
        $where_last_url = '';

        if (isset($_GET["page"])) {
            $sort_name .= '&page='.$_GET["page"];
            $sort_email .= '&page='.$_GET["page"];
            $sort_status .= '&page='.$_GET["page"];
            $where_last_url .= '&page='.$_GET["page"];
            $limit_last_url .= '&page='.$_GET["page"];
        }

        if (isset($_GET["sort"])) {
            $pagination_last_url .= '&sort='.$_GET["sort"];
            $where_last_url .= '&sort='.$_GET["sort"];
            $limit_last_url .= '&sort='.$_GET["sort"];
        } 

        if (isset($_GET["limit"])) {
            $sort_name .= '&limit='.$_GET["limit"];
            $sort_email .= '&limit='.$_GET["limit"];
            $sort_status .= '&limit='.$_GET["limit"];
            $where_last_url .= '&limit='.$_GET["limit"];
            $pagination_last_url .= '&limit='.$_GET["limit"];
        } 
        
        if (isset($_GET["where"])) {
            $sort_name .= '&where='.$_GET["where"];
            $sort_email .= '&where='.$_GET["where"];
            $sort_status .= '&where='.$_GET["where"];
            $limit_last_url .= '&where='.$_GET["where"];
            $pagination_last_url .= '&where='.$_GET["where"];
        }

        $search_last_url = '';
        $array = explode('&', $where_last_url);
        foreach ($array as $key => $value) {
            if ($value != '') {
                $values = explode('=', $value);
                $search_last_url .= "<input type='hidden' name='$values[0]' value='$values[1]'>";
            }
        }

        // Собираем пагинацию
        $pagination = '';
        $params = ['where' => $where];
        $count = $this->model->selectCountTasks($params);
        $count_tasks = $count['tasks'];
        $page_count = ceil($count_tasks / $limit);

        $prev = $page - 1;
        if ($prev < 1) {
            $prev = 1;
            $disabled = 'disabled';
        } else {
            $disabled = '';
        }

        $pagination .= "<li class='page-item $disabled'>
            <a class='page-link' href='tasks?page=$prev$pagination_last_url' tabindex='-1'>Предыдущая</a>
        </li>";

        for ($i = 1; $i <= $page_count; $i++) {
            if ($i == $page) {
                $active = 'active';
            } else {
                $active = '';
            }
            $pagination .= "<li class='page-item $active'>";
            $pagination .= "<a class='page-link' href='tasks?page=$i$pagination_last_url'>$i</a></li>";
        }

        $next = $page + 1;
        if ($next > $page_count) {
            $next = $page_count;
            $disabled = 'disabled';
        } else {
            $disabled = '';
        }
        $pagination .= "<li class='page-item $disabled'>
            <a class='page-link' href='tasks?page=$next$pagination_last_url'>Следующая</a>
        </li>";

        $from_data_tables_info = $from + 1;
        $limit_data_tables_info = $limit * $page;
        if ($limit_data_tables_info > $count_tasks) {
            $limit_data_tables_info = $count_tasks;
        }        
        $data_tables_info = '';
        $data_tables_info .= 'Отображено с '.$from_data_tables_info;
        $data_tables_info .= ' по '.$limit_data_tables_info.' из '.$count_tasks.' записей';

        $where = trim($where, '%');
        $sorting = $sort;

        // Формируем переменные для передаче на страницу
        $vars = [
            'task_list' => $task_list,
            'sorting' => $sorting,
            'sort_name' => $sort_name,
            'sort_email' => $sort_email,
            'sort_status' => $sort_status,
            'pagination' => $pagination,
            'data_tables_info' => $data_tables_info,
            'limit' => $limit,
            'limit_last_url' => $limit_last_url,
            'where' => $where,            
            'search_last_url' => $search_last_url
        ];
        // Устанавливаем заголовок страницы
        $title = 'Список задач | Task manager';
        // Устанавливаем имя шаблона
        $this->view->layout = 'basic-admin-dashboard';
        // Отрисовываем страницу
        $this->view->render($title, $vars);
    }



    /**
     * Создает новую задачу
     */
    public function createAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST["_method"] == "create") {
    
            // Проверяем полученные данные от пользователя
            $users_name = htmlspecialchars(trim($_POST["users_name"]));
            $users_email = filter_var(trim($_POST["users_email"]), FILTER_VALIDATE_EMAIL);
            $task_text = htmlspecialchars(trim($_POST["task_text"]));
            $errors = [];
            if ($users_name === '') {
                $errors[] = 'Пожалуйста, введите имя пользователя';
            }
            if (mb_strlen($users_name) <= 2) {
                $errors[] = 'Минимальная длинна имени пользователя 3 символа.<br>
                             Пожалуйста, введите имя пользователя снова';
            }
            if ($users_email === '' or $users_email === false) {
                $errors[] = 'Пожалуйста, введите E-mail пользователя';
            }
            if ($task_text === '') {
                $errors[] = 'Пожалуйста, введите текст задачи';
            }
            if (mb_strlen($task_text) <= 4) {
                $errors[] = 'Минимальная длинна текста задачи 5 символа.<br>
                             Пожалуйста, введите текст задачи снова';
            }

            // Сохраняем полученные от пользователя данные сессию
            $_SESSION['old']['users_name'] = $users_name;
            $_SESSION['old']['users_email'] = $users_email;
            $_SESSION['old']['task_text'] = $task_text;

            // Если отсутствуют ошибки, выполняем сохранение в БД, иначе выводим ошибку
            if (empty($errors)) {
                $params = ['name' => $users_name, 'email' => $users_email, 'task_text' => $task_text];
                $res = $this->model->createTask($params);
                if ($res) {
                    $_SESSION['success'] = 'Добавление задачи прошло успешно';
                    $this->view->redirect('/tasks');
                } else {
                    $_SESSION['error'] = 'Ошибка при добавлении задачи';
                    $this->view->redirect('/tasks/create');
                }
            } else {
                // Выводим последнюю ошибку
                $_SESSION['error'] = array_shift($errors);
                $this->view->redirect('/tasks/create');
            }

        }

        // Устанавливаем заголовок страницы
        $title = 'Создание задачи | Task manager';
        // Устанавливаем имя шаблона
        $this->view->layout = 'basic-admin-dashboard';
        // Отрисовываем страницу
        $this->view->render($title);
    }



    /**
     * Отображает форму правки задачи
     */
    public function editAction()
    {
        // Проверка права пользователя на доступ к разделу.
        if ($this->accessCheck(['View_task', 'Edit_task'])) {
            $_SESSION['error'] = 'У вас нет на это прав, обратитесь к администратору.';
            $this->view->redirect('/tasks');
        }

        // Проверяем, что задачу с $id существует
        $params = ['id' => $this->route_params['id']];
        if (!$this->model->isTaskExists($params)) {
            $_SESSION['error'] = 'Ошибка при удалении задачи';
            $this->view->redirect('/tasks');
        }

        // Получаем из БД задачу с $id
        $params = ['id' => $this->route_params['id']];
        $result = $this->model->getTask($params);

        // Формируем переменные для передаче на страницу
        $vars = ['value' => $result];
        // Устанавливаем заголовок страницы
        $title = 'Редактирование задачи | Task manager';
        // Устанавливаем имя шаблона
        $this->view->layout = 'basic-admin-dashboard';
        // Отрисовываем страницу
        $this->view->render($title, $vars);
    }



    /**
     * Обновляет задачу
     */
    public function updateAction()
    {
        // Проверка права пользователя на доступ к разделу.
        if ($this->accessCheck(['View_task', 'Edit_task'])) {
            $_SESSION['error'] = 'У вас нет на это прав, обратитесь к администратору.';
            $this->view->redirect('/tasks');
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST["_method"] == "put") {
    
            // Проверяем полученные данные от пользователя
            $task_text = htmlspecialchars(trim($_POST["task_text"]));
            $status = (int)trim($_POST["status"]);
            $task_id = (int)trim($_POST["task_id"]);
            $errors = [];
            if ($task_text === '') {
                $errors[] = 'Пожалуйста, введите текст задачи';
            }
            if (mb_strlen($task_text) <= 4) {
                $errors[] = 'Минимальная длинна текста задачи 5 символа.<br>
                             Пожалуйста, введите текст задачи снова';
            }
            if ($task_id === '') {
                $errors[] = 'Пожалуйста, укажите id задачи';
            }

            // Сохраняем полученные от пользователя данные сессию
            $_SESSION['old']['task_text'] = $task_text;
            if ($status === 1) {
                $_SESSION['old']['status'] = 'checked';
            } else {
                $_SESSION['old']['status'] = '';
            }
           
            // Если отсутствуют ошибки, выполняем сохранение в БД, иначе выводим ошибку
            if (empty($errors)) {

                // Выполняем проверку на изменение текста в задаче
                $params = ['id' => $task_id];
                $task = $this->model->getTask($params);
                if (strcmp($task_text, $task['task_text']) === 0) {
                    $params = ['task_text' => $task_text, 'status' => $status, 'id' => $task_id];
                    $res = $this->model->updateTask($params);
                } else {
                    $edited_by_admin = 1;
                    $params = ['task_text' => $task_text, 'status' => $status,
                               'edited_by_admin' => $edited_by_admin, 'id' => $task_id];
                    $res = $this->model->updateTaskByAdmin($params);
                }
          
                if ($res) {
                    $_SESSION['success'] = 'Обновление задачи прошло успешно';
                    $this->view->redirect('/tasks');
                } else {
                    $_SESSION['error'] = 'Ошибка при обновлении задачи';
                    $this->view->redirect('/tasks/edit/' . $task_id);
                }

            } else {
                $_SESSION['error'] = array_shift($errors);
                $this->view->redirect('/tasks/edit/' . $task_id);
            }
            
        }

        // Устанавливаем заголовок страницы
        $title = 'Список задач | Task manager';
        // Устанавливаем имя шаблона
        $this->view->layout = 'basic-admin-dashboard';
        // Отрисовываем страницу
        $this->view->render($title, $vars);
    }


    /**
     * Удаляет задачу
     */
    public function deleteAction()
    {
        // Проверка права пользователя на доступ к разделу.
        if ($this->accessCheck(['View_task', 'Del_task'])) {
            $_SESSION['error'] = 'У вас нет на это прав, обратитесь к администратору.';
            $this->view->redirect('/tasks');
        }

        // Проверяем, что задачу с $id существует
        $params = ['id' => $this->route_params['id']];
        if (!$this->model->isTaskExists($params)) {
            $_SESSION['error'] = 'Ошибка при удалении задачи';
            $this->view->redirect('/tasks');
        }

        // Удаляем задачу
        $this->model->taskDelete($params);
        $_SESSION['success'] = 'Удаление задачи прошло успешно';
        $this->view->redirect('/tasks');
    }

}
