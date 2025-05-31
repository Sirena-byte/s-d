<?php
// Подключаем файл с функциями для работы с базой данных (например, подключение и выполнение запросов)
require_once("db.php");

/**
 * Добавляет новое сообщение в таблицу messages
 * 
 * @param array $data Массив с данными сообщения: 
 *                    - 'message' (текст сообщения)
 *                    - 'id_user' (ID автора сообщения)
 *                    - 'id_app' (ID заявки, к которой относится сообщение)
 * @return bool Возвращает true при успешном добавлении
 */
function addMessage($data)
{
    // Извлекаем из массива $data только нужные поля для безопасности и удобства
    $data = extractFields($data, ['message', 'id_user', 'id_app']);

    // SQL-запрос для вставки нового сообщения в таблицу messages
    // Поля: text (текст сообщения), id_autor (автор сообщения), id_app (ID заявки)
    $sql = "INSERT INTO `messages`(`text`, `id_autor`, `id_app`) VALUES (:message, :id_user, :id_app)";

    // Выполняем подготовленный запрос к базе данных с передачей параметров из $data
    // Функция dbQuery должна быть реализована в db.php и возвращать объект запроса
    $data = dbQuery($sql, $data);

    // Возвращаем true, чтобы показать успешное выполнение
    // Можно также обработать ошибки и возвращать false при неудаче
    return true;
}

/**
 * Получает все сообщения, относящиеся к заявке с заданным ID
 * 
 * @param int|string $id ID заявки
 * @return array Массив сообщений с дополнительными данными: статус пользователя, имя автора, время сообщения
 */
function getAllMessageOnId($id)
{
    // SQL-запрос выбирает данные из таблицы messages, а также присоединяет таблицы users и application_user
    // Для получения имени автора сообщения и статуса пользователя
    $sql = "SELECT ap.id_user_status, id_message, text, u.name, time_message 
            FROM `messages` m
            JOIN `users` u ON u.id_user = m.id_autor
            JOIN `application_user` ap ON ap.id_user = u.id_user
            WHERE m.id_app = :id";

    // Выполняем запрос с параметром :id, равным ID заявки
    $query = dbQuery($sql, [':id' => $id]);

    // Возвращаем все найденные записи в виде массива
    return $query->fetchAll();
}

/**
 * Получает имена авторов сообщений для заявки с заданным ID
 * 
 * @param int|string $id ID заявки
 * @return array Массив с именами авторов сообщений
 */
function getAutorMesdage($id)
{
    // SQL-запрос выбирает имена пользователей, которые являются авторами сообщений по заданной заявке
    $sql = "SELECT u.name 
            FROM `messages` m
            JOIN `users` u ON u.id_user = m.id_autor
            WHERE m.id_app = :id";

    // Выполняем запрос с параметром :id
    $query = dbQuery($sql, [':id' => $id]);

    // Возвращаем все найденные имена
    return $query->fetchAll();
}

/**
 * Получает статус пользователя по ID заявки
 * 
 * @param int|string $id_app ID заявки (возможно, здесь ошибка в названии параметра, смотрите ниже)
 * @return array Массив со статусом пользователя
 */
function getIdStatusUser($id_app)
{
    // SQL-запрос выбирает статус пользователя из таблицы application_user по ID пользователя
    // Важно: здесь параметр называется id_user, но функция принимает id_app — возможно, ошибка
    $sql = "SELECT id_user_status FROM `application_user` WHERE id_user = :id";

    // Выполняем запрос, передавая параметр :id равным $id_app (возможно, нужно передавать id_user)
    $query = dbQuery($sql, [':id' => $id_app]);

    // Возвращаем результат
    return $query->fetchAll();
}
