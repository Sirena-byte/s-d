<?php

//empty — Проверяет, пуста ли переменная
//isset  — Определяет, объявили ли переменную и отличается ли её значение от null


require_once(__DIR__ . '/../core/c_autorization.php');
$isEntry = false;
if (isset($_POST['autorization-btn'])) {
	$login = $_POST['login'] ?? '';
	if (!empty($_POST['login'])) {
		$pass = $_POST['pass'] ?? '';
		if (!empty($_POST['pass'])) {
			$user = getUser($login) ?? '';
			if (!empty($user)) {
				if ($user[0]['password'] == $pass) {
					//echo "<br> пароли совпадают";
					$_SESSION['user']['name'] = $user[0]['name'];
					$_SESSION['user']['id_user'] = $user[0]['id_user'];
					$isEntry = true;
					$error = '';
				} else {
					$error = 'Пароль не верный';
				}
			} else {
				$error = 'Пользователь ' . $login . ' не найден';
			}
		} else {
			$error = "Введите пароль";
		}
	} else {
		$error = "Введите логин";
	}
} else {
	$error = "";
	//addOldValue('login', $login);
}

if(!isset($_POST['save-info']))
{
	//header('Location: ?page=userApplication');
	//exit();
}