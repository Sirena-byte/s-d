<?php
require_once("./core/db.php");
require_once("./core/core.php");
// Инициализация массива данных о сотруднике с пустыми значениями
//$user = [];
$err = '';
//$pass = $_POST['pass'];
//+
function getAllOrganizations()
{
    $sql = "SELECT id_organization, name FROM `organizations`";
    $query = dbQuery($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
//для ТО
function getDepartmentByOrganizationTO($organizationId): array //+
{
    $sql = "SELECT p.id_place, concat(d.name,' №', p.number) AS name FROM `places_of_work` p 
    JOIN `departments`d ON p.id_department = d.id_department WHERE d.id_organization = :organizationId";
    $query = dbQuery($sql, [':organizationId' => $organizationId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
//для ЦО
function getDepartmentByOrganizationCO($organizationId): array //+
{
    $sql = "SELECT p.id_place, d.name AS name FROM `places_of_work` p 
    JOIN `departments`d ON p.id_department = d.id_department WHERE d.id_organization = :organizationId";
    $query = dbQuery($sql, [':organizationId' => $organizationId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function getPositionsByDepartment($departmentId): array
{
    $sql = "SELECT id_position, name FROM `positions` p JOIN `places_of_work`pl ON pl.id_department = p.id_department WHERE id_place = :departmentId";
    $query = dbQuery($sql, [':departmentId' => $departmentId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function handleRequestUserAdd($err, $user)
{
    ob_start();
    // Проверяем, был ли запрос методом POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получаем и обрабатываем данные из формы
        $user = extractFields($_POST, ['name', 'login', 'pass', 'place', 'isAdmin', 'email', 'position']);

        // Валидация данных перед добавлением
        if (!$err) {
            // Если валидация прошла успешно, добавляем сотрудника
            try {
                addUser($user); // Вызываем метод для добавления сотрудника
                // Перенаправление на главную страницу (закомментировано для тестирования)
                header('Location: ?page=allUsers');
                ob_end_flush(); // Отправляем содержимое буфера
                exit; // Завершаем выполнение скрипта
            } catch (PDOException $e) {
                echo "Произошла ошибка: " . $e->getMessage();
            }
        }
    }
    ob_end_flush();
}


// Метод для добавления сотрудника в базу данных
function addUser($user)
{
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    // SQL-запрос для добавления нового сотрудника
    $sql = "INSERT INTO `users`(`name`, `login`, `password`, `id_place_of_work`, `isAdmin`, `email`, `id_position`) VALUES (:name, :login, :pass, :place, :isAdmin, :email, :position)";

    // Выполняем запрос к базе данных
    $user = dbQuery($sql, $user); // Теперь передаем данные о сотруднике в функцию dbQuery

    // Можно вернуть true или оставить метод пустым, так как успех будет виден через редирект
    return true;
}
function changeUser($user){
    $sql = "UPDATE `users` SET `name`=:name WHERE `id_user`= 2";
    
    $user = dbQueryEdit($sql ,$user);
    return true;
}
function handleRequestChangeUser($err, $user)
{
    ob_start();
    // Проверяем, был ли запрос методом POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получаем и обрабатываем данные из формы
        $user = extractFields($_POST, ['name']);
        // Валидация данных перед добавлением
        if (!$err) {
            // Если валидация прошла успешно, добавляем сотрудника
            try {
                changeUser($user); // Вызываем метод для добавления сотрудника
             
                // Перенаправление на главную страницу (закомментировано для тестирования)
                //header('Location: ?page=allUsers');
                ob_end_flush(); // Отправляем содержимое буфера
                exit; // Завершаем выполнение скрипта
            } catch (PDOException $e) {
                echo "Произошла ошибка: " . $e->getMessage();
            }
        }
    }
    ob_end_flush();
}

function getAllUsers(): array
{
    $sql = "SELECT 
    u.id_user, 
    u.name, 
    u.email, 
    CASE 
        WHEN u.isAdmin = 0 THEN 'noAdmin' 
        WHEN u.isAdmin = 1 THEN 'Admin' 
        ELSE 'Unknown' 
    END AS isAdmin,
    o.name AS organization, 
    CONCAT(d.name, ' ', p.number) AS place, 
    p.address, 
    pos.name AS position 
FROM 
    `users` u 
JOIN 
    `places_of_work` p ON p.id_place = u.id_place_of_work 
JOIN 
    `organizations` o ON p.id_organization = o.id_organization 
JOIN 
    `departments` d ON d.id_department = p.id_department 
JOIN 
    `positions` pos ON pos.id_position = u.id_position;";
    $query = dbQuery($sql);
    return $query->fetchAll();
}


function getUserOnID($id) : array{
    $sql = "SELECT u.id_user, u.name AS user_name, u.email, place.id_organization, place.id_place AS place_of_work,isAdmin, u.id_position  FROM `users` u 
    JOIN `places_of_work` place ON place.id_place = u.id_place_of_work
    JOIN `departments` d ON d.id_department = place.id_department
    WHERE id_user = :id";
    $query = dbQuery($sql,[':id' => $id]);
    return $query->fetchAll();
}

function getPlaceOfWork($id_organization) : array{
    $sql = "SELECT id_place, concat(d.name,' ',p.number) AS name_place FROM `places_of_work` p
JOIN `departments` d ON d.id_department = p.id_department
WHERE id_place = :id_place";
$query = dbQuery($sql, [':id_organization' => $id_organization]);
return $query->fetchAll(PDO::FETCH_ASSOC);
}

function getDepartmentByOrganization($organizationId) : array{
    
    $sql = "SELECT * FROM `departments` WHERE id_organization = :organizationId";
    $query = dbQuery($sql, [':organizationId' => $organizationId]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}