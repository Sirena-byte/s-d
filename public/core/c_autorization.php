<?php
//session_start();
//helpers
//$users = [];
require_once("db.php");
function redirect (string $path){
	header(header: "Location: $path");
	die;
}

function mayBeHasError(string $fieldnasme){
	echo ($_SESSION['validation'][$fieldnasme]) ?? '';
}

function addOldValue(string $key, mixed $value){
	$_SESSION['old'][$key] = $value;
}

function old(string $key){
	return $_SESSION['old'][$key] ?? '';
}

function clearOldValues(string $key){
	return $_SESSION['old'] = [];
}
/**
 * скорее всего не нужна
function getUsers(){
	$sql = "SELECT * FROM `users`";
    $query = dbQuery($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
} */
//$pass = password_hash('admin', PASSWORD_DEFAULT);//зашифровать пароль

function getUser($login){
	$sql = "SELECT * FROM `users` WHERE users.login =:login";
    $query = dbQuery($sql, [':login' => $login]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function errorPass($str){
return $str;
}
//password_verify($password, $user['password']); расшифровать пароль