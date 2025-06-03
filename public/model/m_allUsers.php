<?php require_once("core/c_users.php");
$currentUserName = $_SESSION['user']['name'] ?? '';
$isError = false;

$users = getAllUsers();