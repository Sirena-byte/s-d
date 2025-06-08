<?php
require_once("./core/db.php");
require_once("./core/core.php");

function getAllApp(): array
{
    $sql = "SELECT 
    a.id_app, 
    a.title, 
    ast.name AS status_name, 
    ui.name AS 'инициатор', 
    usa.name AS 'специалист' 
FROM 
    `application` a 
JOIN 
    `application_statuses` ast ON ast.id_app = a.id_status 
JOIN 
    `application_user` aui ON aui.id_app = a.id_app AND aui.id_user_status = 1 
LEFT JOIN 
    `application_user` aus ON aus.id_app = a.id_app AND aus.id_user_status = 2 
JOIN 
    `users` ui ON ui.id_user = aui.id_user 
LEFT JOIN 
    `users` usa ON usa.id_user = aus.id_user 
ORDER BY 
    a.id_app DESC;  -- Сортировка по убыванию";
	 echo $sql;
    $query = dbQuery($sql);
    return $query->fetchAll();
}

function getAllApps($search = null): array
{
    // Начинаем с базового SQL-запроса
    $sql = "SELECT 
        a.id_app, 
        a.title, 
        ast.name AS status_name, 
        ui.name AS 'инициатор', 
        usa.name AS 'специалист' 
    FROM 
        `application` a 
    JOIN 
        `application_statuses` ast ON ast.id_app = a.id_status 
    JOIN 
        `application_user` aui ON aui.id_app = a.id_app AND aui.id_user_status = 1 
    LEFT JOIN 
        `application_user` aus ON aus.id_app = a.id_app AND aus.id_user_status = 2 
    JOIN 
        `users` ui ON ui.id_user = aui.id_user 
    LEFT JOIN 
        `users` usa ON usa.id_user = aus.id_user";

    // Если есть запрос на поиск, добавляем условие WHERE
    if ($search) {
        $sql .= " WHERE 
            a.id_app LIKE :search OR 
            a.title LIKE :search OR 
            ast.name LIKE :search OR 
            ui.name LIKE :search OR 
            usa.name LIKE :search";
    }

    // Добавляем сортировку
    $sql .= " ORDER BY a.id_app DESC";
  
		  $search = '%' . $search . '%';
		  	 //echo $sql;
        $query = dbQuery($sql,[':search' => $search]);
    

    // Выполняем запрос и возвращаем результаты
    //$query->execute();
    return $query->fetchAll();
}