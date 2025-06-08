<?php require_once("core/c_allApp.php");
//$apps = getAllApp();
if($_POST['search'] == '')
{
	$_POST['search'] = 1 ;
}
if(isset($_POST['reset'])){
	$_POST['search'] = 1 ;
}
	$searchQuery = $_POST['search'] ?? '1'; // Получаем значение из запроса
	$param = '111';
$apps = getAllApps($searchQuery);
//$apps = getAllApp();





