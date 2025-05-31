<?php

if(!isset($_SESSION)){
    session_start();
    $_SESSION['user'] = [];
    $_SESSION['user']['login'] = '';
    $_SESSION['user']['password'] = '';
}
/**
 *      echo "</br> post= ";
    print_r($_POST);
        echo "</br> get= ";
    print_r($_GET);
        echo "</br> session= ";
    print_r($_SESSION);
    echo "</br> cookie= ";
    print_r($_COOKIE);
 */

$currentUser = $_SESSION['user']['name'] ?? '';
//global $page;
/*
$target - одномерный массив ассоциативный
$fields - обычный, содержит список строк
$t =[a=>1,b=>2,.....c=>20,d=>40]
$f = [a,c]
*/
/*
function extractFields(array $target, array $fields): array
{
    $res = [];

    foreach ($fields as $field) {
        // Проверяем, существует ли поле в массиве
        if (isset($target[$field])) {
            $value = trim($target[$field]);

            // Проверяем, является ли значение строкой Base64
            if (preg_match('/^data:image\/\w+;base64,/', $value)) {
                // Удаляем префикс
                $value = preg_replace('/^data:image\/\w+;base64,/', '', $value);
            } else {
                // Обрабатываем обычные строки
                $value = htmlspecialchars($value);
            }

            $res[$field] = $value;
        }
    }

    return $res; // Возвращаем массив после обработки всех полей
}*/
 
  function extractFields(array $target, array $fields): array
{
	$res = [];

	foreach ($fields as $field) {
		if($_POST['message']){
			$res[$field] = trim($target[$field]);
		}else{
		$res[$field] = trim(htmlspecialchars($target[$field]));
		}
	}
	return $res;
}