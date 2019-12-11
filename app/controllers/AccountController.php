<?php

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller
{

    /**
     * Регистрация пользователя
     * 
     * @return mixed
     */
    public function registerAction()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Проверяем полученные данные от пользователя
            $login = strip_tags(trim($_POST["login"]));
            $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
            $password = strip_tags($_POST["password"]);
            $errors = [];
            if ($login === '') {
                $errors[] = 'Пожалуйста, введите логин';
            }
            if (mb_strlen($login) <= 2) {
                $errors[] = 'Минимальная длинна логина 3 символа.<br>
                Пожалуйста, введите логин снова';
            }
            if ($email === '' or $email === false) {
                $errors[] = 'Пожалуйста, введите E-mail';
            }
            if ($password === '') {
                $errors[] = 'Пожалуйста, введите пароль';
            }

            // Сохраняем полученные от пользователя данные сессию
            $_SESSION['old']['login'] = $login;
            $_SESSION['old']['email'] = $email;

            // Если отсутствуют ошибки, выполняем регистрацию пользователя, иначе выводим ошибку
            if (empty($errors)) {

                // Проверяем, что в БД нет пользователя с $login
                $params = ['login' => $login];
                $user = $this->model->selectUser($params);
                if ($user['login'] === $login) {
                    $_SESSION['error'] = 'Пользователь с таким логином уже существует';
                    header("Location: /account/register");
                    exit;
                }
                // Проверяем, что в БД нет пользователя с $email
                $params = ['email' => $email];
                $user = $this->model->selectEmail($params);
                if ($user['email'] === $email) {
                    $_SESSION['error'] = 'Пользователь с таким E-mail уже существует';
                    header("Location: /account/register");
                    exit;
                }
                // Хэшируем пароль пользователя преред сохраниение в БД
                $password = password_hash($password, PASSWORD_DEFAULT);
                // Формируем ключ для активации аккаунта
                $active_key = password_hash(mt_rand(), PASSWORD_DEFAULT);
                // Сохраняем нового пользователя в БД
                $params = ['login' => $login, 'email' => $email, 'password' => $password,
                           'active_key' => $active_key, 'active' => 0, 'name' => ''];
                $result = $this->model->createUser($params);
                if ($result) {
                    // Формируем письмо
                    // Задаем получателя
                    $to = 'admin@task-manager.com';
                    // Задаем заголовок письма
                    $subject = 'Регистрация';
                    // Задаем текст письма
                    $message = 'Для завершения регистрации и активации пользователя, перейдите ';
                    $message .= 'по <a href="/account/active?active='.$active_key.'">ссылке</a>';
                    // Задаем дополнительные параметры письма
                    $headers  = 'Contenttype: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: Admin <task-manager.com>' . "\r\n";

                    // Отправляем письмо
                    mail($to, $subject, $message, $headers);
                    // Выполняем переход на главную страницу
                    $_SESSION['success'] = 'Регистрация прошла успешно, Вам на почту отправленно письмо.';
                    header("Location: /");
                    exit;
                } else {
                    $_SESSION['error'] = 'При регистрации произошла ошибка.';
                    header("Location: /account/register");
                }

            } else {
                $_SESSION['error'] = array_shift($errors);
                header("Location: /account/register");
                exit;
            }

        }

        // Устанавливаем заголовок страницы
        $title = 'Регистрация | Task manager';
        // Устанавливаем путь к виду
        $this->view->path = 'account/register';
        // Устанавливаем имя шаблона
        $this->view->layout = 'auth';
        // Отрисовываем страницу
        $this->view->render($title);

    }




    /**
     * Аутентификация пользователя
     * 
     * @return mixed
     */
    public function loginAction()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Проверяем полученные данные от пользователя
            $login = strip_tags(trim($_POST["login"]));
            $password = strip_tags(trim($_POST["password"]));
            $errors = [];
            if ($login === '') {
                $errors[] = 'Пожалуйста, введите логин';
            }
            if (mb_strlen($login) <= 2) {
                $errors[] = 'Минимальная длинна логина 3 символа.<br>
                Пожалуйста, введите логин снова';
            }
            if ($password === '') {
                $errors[] = 'Пожалуйста, введите пароль';
            }

            // Сохраняем полученные от пользователя данные сессию
            $_SESSION['old']['login'] = $login;

            // Если отсутствуют ошибки, выполняем аутентификацию пользователя, иначе выводим ошибку
            if (empty($errors)) {

                // Проверяем, что в БД есть пользователь с $login
                $params = ['login' => $login];
                $user = $this->model->selectUser($params);
                if ($user['login'] === $login) {
                    // Если пользователь найден, то проверяем пароль
                    if (password_verify($password, $user['password'])) {
                        
                        if ($user['active'] == 1) {
                            // Аутентифицируем пользователя и переходим на главную страницу
                            $_SESSION['logged_user']['login'] = $user['login'];
                            header("Location: /");
                            exit;
                        } else {
                            $_SESSION['error'] = 'Пользователь не активирован';
                            header("Location: /account/sign-in");
                            exit;
                        }
                    } else {
                        $_SESSION['error'] = 'Введен не верный пароль';
                        header("Location: /account/sign-in");
                        exit;
                    }
                } else {
                    $_SESSION['error'] = 'Пользователь не найден';
                    header("Location: /account/sign-in");
                    exit;
                }

            } else {
                $_SESSION['error'] = array_shift($errors);
                header("Location: /account/sign-in");
                exit;
            }

        }

        // Устанавливаем заголовок страницы
        $title = 'Вход в приложение | Task manager';
        // Устанавливаем путь к виду
        $this->view->path = 'account/sign-in';
        // Устанавливаем имя шаблона
        $this->view->layout = 'auth';
        // Отрисовываем страницу
        $this->view->render($title);
    }




    /**
     * Восстановление пароля пользователя
     * 
     * @return mixed
     */
    public function resetAction()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Проверяем полученные данные от пользователя
            $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
            if ($email === '' or $email === false) {
                $errors[] = 'Пожалуйста, введите E-mail';
            }

            // Сохраняем полученные от пользователя данные сессию
            $_SESSION['old']['email'] = $email;

            // Если отсутствуют ошибки, ..., иначе выводим ошибку
            if (empty($errors)) {

                // Проверяем, что в БД есть пользователя с $email
                $params = ['email' => $email];
                $user = $this->model->selectEmail($params);

                if ($user['email'] === $email) {

                    // Обновляем пароль в БД
                    $new_password = mt_rand(0000000000, 9999999999);
                    $password = password_hash($new_password, PASSWORD_DEFAULT);
                    $params = ['password' => $password, 'email' => $email];
                    $user = $this->model->resetPasswordUser($params);
                    
                    // Формируем письмо
                    // Задаем получателя
                    $to = $email;
                    // Задаем заголовок письма
                    $subject = 'Восстановление пароля';
                    // Задаем текст письма
                    $message = 'Ваш новый пароль: ' . $new_password . "\r\n";
                    $message .= 'Для аутентификация, перейдите ';
                    $message .= 'по <a href="/account/sign-in">ссылке</a>';
                    // Задаем дополнительные параметры письма
                    $headers  = 'Contenttype: text/html; charset=utf-8' . "\r\n";
                    $headers .= 'From: Admin <task-manager.com>' . "\r\n";

                    // Отправляем письмо
                    mail($to, $subject, $message, $headers);
                    $_SESSION['success'] = 'Вам на почту отправленно письмо содержащее новый пароль.';
                    header("Location: /account/sign-in");
                    exit;
                } else {
                    $_SESSION['error'] = 'Пользователя с таким E-mail не существует';
                    header("Location: /account/reset");
                    exit;
                }
            } else {
                $_SESSION['error'] = array_shift($errors);
                header("Location: /account/reset");
                exit;
            }

        }

        // Устанавливаем заголовок страницы
        $title = 'Восстановление пароля | Task manager';
        // Устанавливаем путь к виду
        $this->view->path = 'account/reset';
        // Устанавливаем имя шаблона
        $this->view->layout = 'auth';
        // Отрисовываем страницу
        $this->view->render($title);
    }




    /**
     * Активация пользователя
     * 
     * @return mixed
     */
    public function activeAction()
    {
        if (isset($_GET["active"])) {
            $active = 1;
            $active_key = $_GET["active"];
            $params = ['active' => $active, 'active_key' => $active_key];
            $user = $this->model->activeUser($params);
            $_SESSION['success'] = 'Активация прошла успешно.';
            header("Location: /");
            exit;
        }
        $_SESSION['error'] = 'Ошибка активации пользователя.';
        header("Location: /");
        exit;
    }




    /**
     * Выход из аккаунта пользователя
     * 
     * @return mixed
     */
    public function logoutAction()
    {
        unset($_SESSION['logged_user']);
        $this->view->redirect('/');
    }

}
