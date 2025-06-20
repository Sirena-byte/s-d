	<?php
	require_once("template/header.php");
	?>

	<head>
		<meta http-equiv="refresh" content="180">
		<link rel="stylesheet" type="text/css" href="src/css/forms.css">
		<link rel="stylesheet" type="text/css" href="src/css/table.css">
		<link rel="stylesheet" type="text/css" href="src/css/allstyle.css">
		<link rel="stylesheet" type="text/css" href="src/css/style.css">

	</head>
	<div class="content ">
		<!-- Форма для поиска -->
<form method="POST">
    <input type="text" name="search" placeholder="Введите запрос...">
    <button type="submit">Поиск</button>
	  <button type="submit" name="reset" value="Сброс">Сброс</button>
</form>

		<div class="edit-user-form">
			<div class="block-content all-app">
				<table>
					<thead>
						<tr>
							<th>номер заявки</th>
							<th>тема заявки</th>
							<th>статус</th>
							<th>инициатор запроса</th>
							<th>назначен специалист</th>
						</tr>
					</thead>
					<tbody>
						<?php
						require_once("model/m_allApp.php");
						foreach ($apps as $app): ?>
							<tr>
								<?php foreach ($app as $item): ?>
									<td><a class="a-table" href="?page=application&id=<?= $app['id_app']; ?>" target="_blank"><?= $item ?></a></td>
								<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>