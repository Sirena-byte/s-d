<?php

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/style.css">

    <title>HD</title>
</head>

<body>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'autorization'; // По умолчанию organization
    // Определяем путь к файлу
    $pageFile = "pages/" . $page . ".php"; //pages/page.php
    // Проверяем, существует ли файл
    if (file_exists($pageFile)) {
        include $pageFile; // Включаем нужный файл
    } else {
        include_once 'template/404.php'; // Страница не найдена
    }
    ?>