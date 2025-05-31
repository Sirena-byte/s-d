

<?php
//session_start();
require_once(__DIR__ . '/../core/c_autorization.php');
$_SESSION['validation'] = [];
$login = $_POST['login'] ?? '';
//$_SESSION['user'] = [];
$pass = $_POST['pass'] ?? '';
$validationLogin = $_SESSION['validation']['login'] ?? '';
$validationPass = $_SESSION['validation']['pass'] ?? '';

//$user = getUser($login) ?? '';

//echo "current = ". $currentUser;
//print_r($_SESSION);
$error = '';

//если логин и пароль и отправить пустые, то заполнить поля


if (!empty($_POST['autorization-btn'])) {
    if (!empty($login)) { //если логин не пустой и нажата кнопка отправить
        if (!empty($pass)) {
            $user = getUser($login) ?? '';
            $currentUserName = $user[0]['name'] ?? '';
            if ($user) {
                // Проверяем, существует ли ключ 'password' и выполняем проверку пароля
                if (!isset($user['password']) && $user[0]['password'] === $pass) {
                    $_SESSION['user'] = $user[0];
                    //$testUser = $_SESSION['user']['name'] ?? '';
                    //redirect("../pages/test.php");

                } else {
                    $error = errorPass("Не верный пароль");
                }
            } else {
                $error = errorPass("Пользователь $login не найден");
            }
        } else {
            $error = 'неверный пароль';
        }
    } else {
        $error = 'Заполните поля';
    }
}else{
$error = '';
}
