<?php
//require_once('model/m_autorization.php');
require_once('model/m_autorization.php');
//$hash = password_hash($password, PASSWORD_DEFAULT);
//if (password_verify($password, $hash)) {
    // Пароль верный
//}


?>
<?php
if (empty($_POST) || ($isEntry == false)): ?>
	<head>
		<link rel="stylesheet" type="text/css" href="src/css/autorization.css">
	</head>
	<div class="content">

		<div class="content-form autorization">
			<p>Авторизация</p>
			<div class="autorization-image"><img src="src/icon/avatar.png" alt=""></div>
			<form class="form" action="#" method="post">
				<input value="<?= $login ?? ''; ?>" type="text" name="login" value="" placeholder="Логин">
				<input type="password " name="pass" value="" placeholder="Пароль">
				<button class="autorization-btn" type="submit" name="autorization-btn">Авторизоваться</button>
			</form>
			<div class="error"><p><?=$error ?></p></div>
		</div>
	</div>
<?php else : ?>
	<?php require_once("template/header.php"); ?>
	<div class="content">
		<p><?=$user[0]['name'] ?></p>
	</div>

<?php endif;  ?>