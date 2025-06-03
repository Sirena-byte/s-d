
	<?php
	require_once('template/header.php');
	?>
	<head>
		
		<link rel="stylesheet" type="text/css" href="src/css/forms.css">
		<link rel="stylesheet" type="text/css" href="src/css/table.css">
		<link rel="stylesheet" type="text/css" href="src/css/allstyle.css">
		<link rel="stylesheet" type="text/css" href="src/css/style.css">
		
	</head>
<?php
//require_once('model/m_users.php');
//require_once('model/m_editUser.php');
?>
<div class="content ">
	<div class="edit-user-form">
		<div class="block-content ">
			<table>
				<thead>
					<tr>
						<th>№</th>
						<th>id</th>
						<th>ФИО</th>
						<th>email</th>
						<th>Админ</th>
						<th>Организация</th>
						<th>Место работы</th>
						<th>Адрес</th>
						<th>Должность</th>
						<th class="edit-column" colspan="2"></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$number = 1; //порядковый номер для таблицы
					require_once("model/m_allUsers.php");
					foreach ($users as $user): ?>
						<tr>
							<td><?= $number ?></td>
							<?php foreach ($user as $item): ?>
								<td><?= $item ?></td>
							<?php endforeach; ?>
							<!-- формы для редактирования и удаления -->
							<td class="edit-sell">

								<form method="POST" action="">
									<input type="hidden" name="id_user" value="<?= $user['id_user']; ?>"> <!-- Скрытое поле с id -->
									<button class="admin-btn" type="submit" name="edit_entry_user" value="edit"><img src="src/icon/edit.png" alt="Редактировать"></button>
								</form>
							</td>
							<td class="edit-sell">
								<form method="POST" action="">
									<input type="hidden" name="id_user" value="<?= $user['id_user']; ?>"> <!-- Скрытое поле с id -->
									<button class="admin-btn" type="submit" name="delete_entry_user" value="delete"><img src="src/icon/delete.png" alt="Удалить"></button>
								</form>
							</td>
						</tr>
						<?php $number++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<!-- Блоки редактирования и удаления -->
<?php require_once("model/m_editUser.php"); ?>
		<div class= "editUser">

			<div class="form-content">
				<h3>Редактирование пользователя <?= $_POST['id_user'] ?? '1'; ?></h3>
				<form method="POST">
					<input type="hidden" name="id_user" value="<?= $_POST['id_user'] ?? '1'; ?>">
					<input type="text" name="name" value="<?= $_POST['name'] ?? $userEdit[0]['user_name'] ; ?>" placeholder="ФИО">
					<input type="text" name="email" value="<?=$_POST['email'] ?? $userEdit[0]['email'] ; ?>" placeholder="Email">

					<div class="content-checkbox">
						<label for="organization">Место работы</label>
						<select id="organization" name="organization" onchange="this.form.submit()">
							<option value="">Выберите организацию</option>
							<?php foreach ($organizations as $organization): ?>
								<option value="<?= $organization['id_organization']; ?>" <?= ($organization['id_organization'] == $selectedOrganizationId) ? 'selected' : $userEdit[0]['id_organization']; ?>>
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
								<option value="<?= $place['id_place']; ?>" <?= ($place['id_place'] == $selectedPlaceId) ? 'selected' : $userEdit[0]['place_of_work']; ?>>
									<?= htmlspecialchars($place['name']); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="content-checkbox">
						<label for="position">Должность:</label>
						<select id="position" name="position">
							<option value="">Выберите должность</option>
							<?php foreach ($positions as $position): ?>
								<option value="<?= $position['id_position']; ?>" <?= ($position['id_position'] == $selectedPositionId) ? 'selected' : $userEdit[0]['id_position']; ?>>
									<?= htmlspecialchars($position['name']); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="checkbox edit-checkbox">
						<label for="">Доступ к администрированию</label>
						<input type="hidden" name="isAdmin" value="0">
						<input type="checkbox" name="isAdmin" value=<?=$_POST['isAdmin'] ?? $userEdit[0]['isAdmin'] ; ?> <?= (isset($isAdmin) && $isAdmin) ? 'checked' : $userEdit[0]['isAdmin']; ?>>
					</div>

					<div class="admin_panel">
						<button class="save-btn" type="submit" name="save_user" value="submit">Отправить</button>
						
					</div>
				</form>
			</div>

		</div>
	</div>
</div>




<div class="addata deleteUser" style="<?= (isset($_POST['delete_entry_user'])) ? 'display: block;' : 'display: none;'; ?>">
	<h3>Удалить пользователя</h3>
	<p>Вы уверены, что хотите удалить пользователя с ID <?= $_POST['user_id'] ?? ''; ?>?</p>

	<?php if (isset($_POST['delete_entry_user'])) : ?>
		<form method="POST" action="">
			<input type="hidden" name="user_id" value="<?= $_POST['user_id'] ?? ''; ?>">
			
			<button type="submit" name="confirm_delete">Удалить</button>
			<button type="submit" name="cancel_delete">Отмена</button>
		</form>
	<?php endif; ?>
</div>

</div>
