<?php
require_once("./core/db.php");
require_once("./core/core.php");
$organizationName = '';
$organization = [];
$err = '';

function getOrganizations($start, $finish): array
{
	$sql = "SELECT o.name AS organization_name, d.name, d.address
FROM `departments` d
JOIN `organizations` o ON d.id_organization = o.id_organization
LIMIT $start, $finish";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getOrganization($id): array
{
	$sql = "SELECT name FROM `organizations` WHERE id_organization = $id";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getFullOrganizations(): array
{
	$sql = "SELECT `name` FROM `organizations`";
	$query = dbQuery($sql);
	return $query->fetchAll();
}

function getCountOrganizations()
{
	$sql = "SELECT COUNT(*) AS total_records FROM `organizations`";
	$query = dbQuery($sql);

	// Извлекаем результат из объекта PDOStatement
	if ($query) {
		$result = $query->fetch(PDO::FETCH_ASSOC);
		return $result['total_records'];
	}

	return 0; // Возвращаем 0, если запрос не удался
}
/*
//замена симола статуса на строковое значение при печати
function replaceStatus($status): string
{
	if ($status === '1') {
		$status = "Активен";
	} else {
		$status = "Не активен";
	}
	return $status;
}
*/
function handleRequest($error, $organization)
{
	ob_start();
	// Проверяем, был ли запрос методом POST
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// Получаем и обрабатываем данные из формы
		$organization = extractFields($_POST, ['name', 'addres']); // Исправлено 'addres' на 'address'

		// Валидация данных перед добавлением
		if (!$error) {
			// Если валидация прошла успешно, добавляем организацию
			organizationAdd($organization);
			header('Location: ?page=organization'); // Указываем адрес для перенаправления
			ob_end_flush(); // Отправляем содержимое буфера
			exit();
		}
	}
	ob_end_flush();
}
function organizationAdd(array $organization): bool
{
	$sql = "INSERT organizations (name, addres) VALUES (:name, :addres)";
	dbQuery($sql, $organization);
	return true;
}

function genericForm()
{
	echo "<div class=\"succsess\">";
	echo "<h1>Данные успешно добавлены</h1>";
	echo "<a href=\"pages/organization.php\">test</a>";
	echo "</div>";
	print_r($_GET['page']);
}

function test()
{
	return "test-test";
}