<?php
require_once("core/c_users.php");


$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$login = $_POST['login'] ?? '';
$pass = $_POST['pass'] ?? '';
$isError = false;


$selectedOrganizationId = $_POST['organization'] ?? '';
$selectedPlaceId = $_POST['place'] ?? '';
$selectedPositionId = ($_POST['position'])  ?? '';

$places = [];
$organizations = getAllOrganizations();

$positions = [];

if (!empty($selectedOrganizationId)) {
	if($selectedOrganizationId == 1){
		$places = getDepartmentByOrganizationTO($selectedOrganizationId);
	}else{
		$places = getDepartmentByOrganizationCO($selectedOrganizationId);
	}
}

if(!empty($selectedPlaceId)){
	$positions = getPositionsByDepartment($selectedPlaceId);
}else{

}
// Проверяем, была ли форма отправлена через метод POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Проверяем, заполнены ли обязательные поля 'name' и 'addres'
	if ($name === '' || $email ===''|| $selectedOrganizationId === '' || $selectedPlaceId === '' || $login === '' || $pass === '') {
		// Если одно из полей пустое, устанавливаем переменную $isError в true
		$isError = true;
	} else {
		// Если оба поля заполнены, сбрасываем флаг ошибки
		$isError = false;

		// Заполняем массив данными из POST
		$user = $_POST;
		handleRequestUserAdd($isError, $users);
	}
}