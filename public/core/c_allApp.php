<?php
require_once("./core/db.php");
require_once("./core/core.php");

function getAllApp(): array
{
    $sql = "SELECT 
    a.id_app, 
    a.title, 
    a.id_status, 
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
    $query = dbQuery($sql);
    return $query->fetchAll();
}

