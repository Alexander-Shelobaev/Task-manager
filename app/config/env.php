<?php
/*
Среда pазработки [dev] — та среда (база данных, сайт, ВМ и т.д.), где развёртываем 
свежий код и смотрим, что получается.
*/
error_reporting(E_ALL);
// display_errors(on);
// log_error();
// error_log();
// ini_set("error_log", "log. txt");
// ini_set("log_errors", true);
define("APP_NAME", "Task manager");
define("APP_URL", "http://task-manager.loc/");

// Настройки подключения к БД
define("DB_HOST", "localhost");
define("DB_NAME", "Mvc");
define("DB_USER", "root");
define("DB_PASSWORD", "");
// Режим вывода ошибок БД
define("DB_ERRMODE", "PDO::ERRMODE_EXCEPTION");

function pr($str)
{
    echo '<pre>';
    print_r($str);
    echo '</pre>';
}

/*
Демо [demo] — тут промежуточный результат показывается заказчику. Пока 
развёрнутый здесь полуготовый функционал ждёт внимания заказчика, на [dev] 
можно всё сломать, работая дальше.
*/

/*
Тестовая [test] — тут тестируется функциональность. Среда наполнена тестовыми
данными, которые могут отражать редко возникающие (в рабочей среде) случаи или
быть удобными для тестирования. Пока тут идёт тестирование того, что готовится
в продакшен, на [dev] уже появляется код следующего релиза.
*/

/*
Промежуточная [stage], она же предпродакшен — тут тестируется развёртывание.
Сюда развёртывается последний бэкап системы из продакшена, чтобы проверить
обновление на версию.
*/

/*
Продакшен [prod] — тут работают пользователи.
*/