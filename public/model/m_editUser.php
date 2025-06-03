<?php
require_once("core/c_users.php");
if (isset($_POST['id_user'])) {
	$userEdit = getUserOnID($_POST['id_user']);
} else {
	$userEdit = getUserOnID('1');
}
$organizations = getAllOrganizations();
$userName = $userEdit[0]['user_name'];
$userEmail = $userEdit[0]['email'];

$name = $_POST['name'] ?? $userEdit[0]['user_name'];
$email = $_POST['email'] ?? $userEdit[0]['email'];

$isError = false;
$selectedOrganizationId = $_POST['organization'] ?? $userEdit[0]['id_organization'];
$selectedPlaceId = $_POST['place'] ?? $userEdit[0]['place_of_work'];
$selectedPositionId = ($_POST['position'])  ?? $userEdit[0]['id_position'];

//$userName = '';
//$userEmail = '';

$places = [];

$positions = [];

if (!empty($selectedOrganizationId)) {
	if ($selectedOrganizationId == 1) {
		$places = getDepartmentByOrganizationTO($selectedOrganizationId);
	} else {
		$places = getDepartmentByOrganizationCO($selectedOrganizationId);
	}
}

if (!empty($selectedPlaceId)) {
	$positions = getPositionsByDepartment($selectedPlaceId);
} else {
}



// Проверяем, была ли форма отправлена через метод POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['save_user'])) {
		// Проверяем, заполнены ли обязательные поля 'name' и 'addres'
		if ($name === '' || $email === '' || $selectedOrganizationId === '' || $selectedPlaceId === '' || $selectedPositionId === '') {
			// Если одно из полей пустое, устанавливаем переменную $isError в true
			$isError = true;
		} else {
			// Если оба поля заполнены, сбрасываем флаг ошибки
			$isError = false;

			// Заполняем массив данными из POST
			handleRequestChangeUser($isError, $users,(int)$_POST['id_user']);
		}
	}
}
