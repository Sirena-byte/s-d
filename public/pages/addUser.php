<?php
require_once("model/m_addUser.php");
?>
	<head>
		
		<link rel="stylesheet" type="text/css" href="src/css/forms.css">
		<link rel="stylesheet" type="text/css" href="src/css/table.css">
		<link rel="stylesheet" type="text/css" href="src/css/allstyle.css">
		<link rel="stylesheet" type="text/css" href="src/css/style.css">
		
	</head>
<div class="addata addemployee">
    <h3>Добавить сотрудника</h3>
    <div class="form-content">
        <form method="POST">
            <input type="text" name="name" value="<?=$name;?>" placeholder="ФИО">
            <input type="text" name="email" value="<?= $email; ?>" placeholder="Email">

            <div class="content-checkbox">
                <label for="organization">Место работы</label>
                <select id="organization" name="organization" onchange="this.form.submit()">
                    <option value="">Выберите организацию</option>
                    <?php foreach ($organizations as $organization): ?>
                        <option value="<?= $organization['id_organization']; ?>" <?= ($organization['id_organization'] == $selectedOrganizationId) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($organization['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
				
            <div class="content-checkbox">
                <label for="department">Отдел:</label>
                <select id="place" name="place" onchange="this.form.submit()">
                    <option value="">Выберите отдел:</option>
                    <?php foreach ($places as $place): ?>
                        <option value="<?= $place['id_place']; ?>" <?= ($place['id_place'] == $selectedPlaceId) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($place['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
				<div class="content-checkbox">
                <label for="position">Должность:</label>
                <select id="position" name="position"">
                    <option value="">Выберите должность</option>
                    <?php foreach ($positions as $position): ?>
                        <option value="<?= $position['id_position']; ?>" <?= ($position['id_position'] == $selectedPositionId) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($position['name']); ?>
                        </option>
                        
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="text" name="login" value="<?= $login ?>" placeholder="Логин">
            <input type="text" name="pass" value="" placeholder="Пароль">
            <div class="checkbox">
            <label for="">Доступ к администрированию</label>
            <input type="hidden" name="isAdmin" value="0">
            <input type="checkbox" name="isAdmin" value="1" placeholder="Admin"> 
            </div>
            <div class="admin_panel">
            <button class="save-btn" type="submit">Отправить</button>
            <button class="cancel-btn" type="submit" name="cancel_edit"><a href="?page=allUsers">Отмена</a></button>
            </div>
        </form>
    </div>
    <div class="err">
        <?= $_SESSION['error_message'] ?? ''; ?>
    </div>
    <!-- Проверка на ошибки и вывод сообщения, если есть ошибка -->
    <?php if ($isError === true): ?>
                <!--<div class="err">Заполните все поля</div>
            <?php endif; ?>
</div>
    