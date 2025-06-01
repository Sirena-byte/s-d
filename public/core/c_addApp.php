<?php
function renameFileWithTimestamp($file) {
    // Получаем временную метку
    $timestamp = time();
    
    // Получаем расширение файла
    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
    
    // Создаем новое имя файла
    $newFileName = $timestamp . '.' . $fileExtension;
    
    return $newFileName;
}

function handleRequestAppAdd($err, $app, $app_user)
{
	ob_start();
	// Проверяем, был ли запрос методом POST
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Получаем и обрабатываем данные из формы
		$app = extractFields($app, ['title', 'file', 'text']);


		// Валидация данных перед добавлением
		if (!$err) {
			// Если валидация прошла успешно, добавляем заявку
			try {
				$currentIdApp = addApp($app); // Получаем ID добавленной заявки
				$app_user['id_app'] = $currentIdApp;
				$app_user['id_user_status'] = 1;
				$app_user = extractFields($app_user, ['id_user', 'id_app', 'id_user_status']);

				addUserApp($app_user); // Передаем ID в функцию добавления пользователя

				// Перенаправление на главную страницу 
				ob_start(); // Начинаем буферизацию вывода
				$str = 'Location: ?page=application&id=' . $currentIdApp;
				header($str);
				$_GET['page'] = '?page=application&id=' . $currentIdApp;
				ob_end_flush();
				exit; // Завершаем выполнение скрипта
			} catch (PDOException $e) {
				//echo "Произошла ошибка: " . $e->getMessage();
			}
		}
	}
	ob_end_flush();
	header('Location: ?page=application');
	return $currentIdApp;//возвращаем ID заявки
}

// Метод для добавления заявки в базу данных
function addApp($app)
{
	$sql = "INSERT INTO `application` (`title`, `file`, `text`) VALUES (:title, :file, :text)";

	// Подготовка и выполнение запроса
	dbQuery($sql, $app); // Выполняем запрос, но не сохраняем результат

	// Получение ID последней вставленной записи
	return dbInstance()->lastInsertId(); // Возвращаем ID
}

function addUserApp($app_user)
{
	// добавление пользователя к заявке
	$sql = "INSERT INTO `application_user` (`id_user`, `id_app`,`id_user_status`) VALUES (:id_user, :id_app,:id_user_status)";
	$app_user = dbQuery($sql, $app_user); // Выполнение запроса
	return true;
}

function getApplicationOnId($id)
{
	$sql = "SELECT a.title, a.text, a.file, au.time_change, u.name AS user_name, u.id_user, u.email, o.name AS organization, d.name AS department, p.address, us.name AS status_user FROM `application` a JOIN `application_user`au ON a.id_app = au.id_app JOIN `users` u ON u.id_user = au.id_user JOIN `places_of_work` p ON p.id_place = u.id_place_of_work JOIN `organizations` o ON o.id_organization = p.id_organization JOIN `departments` d ON d.id_department = p.id_department JOIN `user_statuses` us ON us.id_status = au.id_user_status WHERE a.id_app = :id";
    $query = dbQuery($sql,[':id' => $id]);
    return $query->fetchAll();
}