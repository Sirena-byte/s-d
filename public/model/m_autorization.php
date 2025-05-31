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
			$user_t = getUser($login) ?? '';
			if (!empty($user_t)) {
				if ($user_t[0]['password'] == $pass) {
					echo "<br> пароли совпадают";
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
}
