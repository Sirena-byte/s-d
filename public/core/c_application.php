<?php

function addMessage($data)
{
	// добавление сообщения
	$sql = "INSERT INTO `messages` (`text`, `id_app`,`id_autor`) VALUES (:text, :id_app,:id_user)";
	$data = dbQuery($sql, $data); // Выполнение запроса
	return true;
}

function handleRequestAddMessage($err, $data)
{
	ob_start();
	// Проверяем, был ли запрос методом POST
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Получаем и обрабатываем данные из формы
		$data = extractFields($data, ['text', 'id_app', 'id_user']);


		// Валидация данных перед добавлением
		if (!$err) {
			// Если валидация прошла успешно, добавляем заявку
			try {

				addMessage($data); // Передаем ID в функцию добавления пользователя

			} catch (PDOException $e) {
				//echo "Произошла ошибка: " . $e->getMessage();
			}
		}
	}
}

function getMessagesOnIdApp($id)
{
	$sql = "SELECT id_message, text, id_autor, name, time_message, id_user_status
FROM `messages` m
JOIN `users` u ON u.id_user = m.id_autor
JOIN `application_user` a ON a.id_app = m.id_app AND a.id_user = m.id_autor
WHERE m.id_app = :id 
ORDER BY `time_message` DESC";
	$query = dbQuery($sql, [':id' => $id]);
	return $query->fetchAll();
}

function getStatusApp($id)
{
	$sql = "SELECT id_status, s.name FROM `application` a
JOIN application_statuses s ON s.id_app = a.id_status
WHERE a.id_app = :id";
	$query = dbQuery($sql, [':id' => $id]);
	return $query->fetchAll();
}
//получить пользователя по его ид
function getUseronID($id)
{
	$sql = "SELECT * FROM `users` WHERE id_user = :id";
	$query = dbQuery($sql, [':id' => $id]);
	return $query->fetchAll();
}

//получить ид инициатора заявки 
function getIdInitionApp($id_app)
{
	$sql = "SELECT id_user FROM `application_user` WHERE id_user_status = 1 AND id_app = :id";
	$query = dbQuery($sql, [':id' => $id_app]);
	return $query->fetchAll();

}
//получить id пользователя, связанного с заявкой
function getIDUserLinkApp($id_app, $id_user_status)
{
    $sql = "SELECT id_user FROM `application_user` WHERE id_app = :id_app AND id_user_status = :id_user_status";
    
    // Объединяем параметры в один массив
    $params = [
        ':id_app' => $id_app,
        ':id_user_status' => $id_user_status

    ];
    
    $query = dbQuery($sql, $params);
    
    // Возвращаем только одно значение
    return $query->fetchColumn();
}

function addLinkToApp($data)
{
$sql = "INSERT INTO `application_user`(`id_user`, `id_app`, `id_user_status`) VALUES (:id_user, :id_app , :id_user_status)";
$data = dbQuery($sql, $data); // Выполнение запроса
	return true;
}


function handleRequestAddLinkToApp($err, $data)
{
	ob_start();
		// Получаем и обрабатываем данные из формы
		$data = extractFields($data, ['id_user', 'id_app', 'id_user_status']);
		// Валидация данных перед добавлением
		if (!$err) {
			// Если валидация прошла успешно, добавляем заявку
			try {

				addLinkToApp($data); // Передаем ID в функцию добавления пользователя
				$dataChange['id_app'] = $data['id_app'];
				changeStatusApp($dataChange);

			} catch (PDOException $e) {
				//echo "Произошла ошибка: " . $e->getMessage();
			}
		}
}

function changeStatusApp($app){
    $sql = "UPDATE `application` SET `id_status`= :id_status WHERE id_app = :id_app";
    
    $app = dbQueryEdit($sql ,$app);
    return true;
}

