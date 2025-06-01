<?php
require_once("core.php");
require_once("config.php");

function dbInstance(): PDO
{
    static $db;
    if ($db === null) {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, USER_NAME, DB_PASS, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $db->exec('SET NAMES UTF8');
    }
    return $db;
}

function dbQuery(string $sql, array $params = [])
{
    try {
        $db = dbInstance();
        $query = $db->prepare($sql);
        $query->execute($params);
        dbCheckError($query);
        return $query;
    } catch (PDOException $e) {
        // Запись ошибки в файл
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - " . $e->getMessage() . "\n", FILE_APPEND);

        // Получаем код ошибки
        $errorCode = $e->errorInfo[1]; // Код ошибки из PDOException
        $_SESSION['errCode'] = $e->errorInfo[1];
        // Получаем сообщение об ошибке из функции messageErr
        $errorMessage = messageErr($errorCode);

        // Сохраняем сообщение об ошибке в сессии
        $_SESSION['error_message'] = $errorMessage ?: "Произошла ошибка: " . $e->getMessage();
        if (isset($_POST['submit_edit'])) {
            // Перенаправление на форму
            header('Location: ?page=addUser');
            exit();
        }
    }
}

function dbQueryEdit(string $sql, array $params = [])
{
    try {
        $db = dbInstance();

        $query = $db->prepare($sql);
        $query->execute($params);
        dbCheckError($query);
        return $query;
    } catch (PDOException $e) {
        // Запись ошибки в файл
        file_put_contents('error_log.txt', date('Y-m-d H:i:s') . " - " . $e->getMessage() . "\n", FILE_APPEND);

        // Получаем код ошибки
        $errorCode = $e->errorInfo[1]; // Код ошибки из PDOException
        $_SESSION['errCode'] = $e->errorInfo[1];
        // Получаем сообщение об ошибке из функции messageErr
        $errorMessage = messageErr($errorCode);

        // Сохраняем сообщение об ошибке в сессии
        $_SESSION['error_message'] = $errorMessage ?: "Произошла ошибка: " . $e->getMessage();
        if (isset($_POST['submit_edit'])) {
            // Перенаправление на форму
            header('Location: ?page=addUser');
            exit();
        }
    }
}

function messageErr($err)
{
    switch ($err) {
        case 1062:
            return "Нарушена уникальность поля. Пользователь с таким email уже существует. Устраните ошибку или обратитесь к администратору";
        case 1045:
            return "Ошибка доступа: неверное имя пользователя или пароль. Устраните ошибку или обратитесь к администратору";
        case 1146:
            return "Таблица не найдена. Устраните ошибку или обратитесь к администратору";
        case 1054:
            return "Неизвестный столбец. Устраните ошибку или обратитесь к администратору";
        case 1064:
            return "Ошибка синтаксиса в SQL-запросе. Устраните ошибку или обратитесь к администратору";
        case 1451:
            return "Невозможно удалить или обновить родительскую строку. Устраните ошибку или обратитесь к администратору";
        case 2002:
            return "Невозможно подключиться к локальному серверу MySQL. Устраните ошибку или обратитесь к администратору";
        case 1213:
            return "Обнаружен взаимный блок. Устраните ошибку или обратитесь к администратору";
        case 1205:
            return "Время ожидания блокировки превышено. Устраните ошибку или обратитесь к администратору";
        case 1136:
            return "Количество столбцов не соответствует количеству значений. Устраните ошибку или обратитесь к администратору";
        default:
            return "Произошла неизвестная ошибка: " . $err . " Устраните ошибку или обратитесь к администратору";
    }
}

function dbCheckError(PDOStatement $query): bool
{
    // Получаем информацию об ошибке из PDOStatement
    $errInfo = $query->errorInfo();
    //print_r($query);
    if ($errInfo[0] !== PDO::ERR_NONE) {
        // Формируем сообщение об ошибке с временной меткой
        $errorMessage = date('Y-m-d H:i:s') . " - Error: " . $errInfo[2] . PHP_EOL;
        // Записываем сообщение в файл журнала ошибок
        // 'error_log.txt' - имя файла, в который будут записываться ошибки
        // FILE_APPEND - указывает, что новое сообщение будет добавлено в конец файла
        file_put_contents('error_log.txt', $errorMessage, FILE_APPEND);
        // Выводим общее сообщение для пользователя, чтобы не раскрывать детали ошибки
       // echo "<p class=\"errorDB\">\"Произошла ошибка. Пожалуйста, проверьте журнал ошибок.\"</p>";
        exit();
    }
    return true;
}