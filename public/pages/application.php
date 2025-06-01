	<?php
	require_once("template/header.php");
	require_once("model/m_application.php");
	//$filePath = "../src/files/.$application[0]['file']";
	?>

	<head>
		<link rel="stylesheet" type="text/css" href="src/css/style.css">
		<link rel="stylesheet" type="text/css" href="src/css/application.css">
	</head>
	<div class="content application">
		<div class="application-content">

			<div class="content-application">
				<div class="application-messages">
					<?php if (isset($_POST['edd_message'])) : ?>
						<div class="form-message">
							<form method="post">
								<div class="mess">
									<div class="mess-text">
										<textarea name="message" id=""></textarea>
									</div>
									<div class="mess-btn">
										<button type="submit" name="submit_message" value="submit">Отправить</button>
										<button type="submit" class="reject-btn">Отмена</button>
									</div>
								</div>
							</form>
						</div>
					<?php endif ?>
					<div class="message-first">
						<div class="message-title">
							<h3><?= $application[0]['title'] . "( ID: " . ((int)$_GET['id']) . " ) " ?><span class="status"><?= $statusApp[0]['name'] ?></span></h3>
						</div>
						<div class="message-text">
							<p><?= $application[0]['text'] ?></p>
							<div class="image"><img src="src/files/<?= $application[0]['file'] ?>" alt=""></div>
						</div>
					</div>
					<div class="info">
						<?php //print_r($_POST)?>
						<?php //print_r($dataLink['id_app']) ?>
						<?php //print_r($statusApp) ?>
						<?php //print_r($_SESSION['user']['name']) ?>
						<?php //print_r($currentUser[0]) ?>
						<?php //print_r($userInit) ?>
						<?php print_r($executerUserId) ?>
						<?php //print_r($dataLink) ?>
					</div>
					<div class="message-all">
						<?php if (!empty($messages)) : ?>
							<?php foreach ($messages as $message) : ?>
								<?php if ($message['id_user_status'] == 1) : ?>
									<div class="block-message init-user">
										<div class="block-info">
											<p><?= $message['text'] ?></p>
											<div class="info-mesage-user">
												<span><?= $message['name'] . "(" . $message['id_user_status'] . ")" ?></span>
												<span><?= $message['time_message'] ?></span>
											</div>
										</div>
									</div>
								<?php else : ?>
									<div class="block-message">
										<p><?= $message['text'] ?></p>
										<div class="info-mesage-user">
											<span><?= $message['name'] . "(" . $message['id_user_status'] . ")" ?></span>
											<span><?= $message['time_message'] ?></span>
										</div>
									</div>
								<?php endif ?>
							<?php endforeach ?>
						<?php endif ?>

					</div>
				</div>

			</div>
			<div class="content-config">
				<?php foreach ($application as $app) : ?>
					<?php if ($app['status_user'] == 'Инициатор заявки') : ?>
						<div class="conf-init">
							<fieldset>
								<legend style="padding:20px 0; font-size:20px;">Инициатор:</legend>
								<p>Имя: <?= $application[0]['user_name'] . " (email: " . $application[0]['email'] . ")" ?></p>
								<p>Место работы: <?= $application[0]['organization'] . "/" . $application[0]['department'] . "/" . $application[0]['address'] ?></p>
								<p>Дата создания заявки: <?= $application[0]['time_change'] ?></p>
							</fieldset>
						</div>
					<?php endif ?>
					
						<div class="conf-executor">
							<div class="executor-info">
								<?php if($app['status_user'] == 'Исполнитель заявки') :?>
								<fieldset>
									<legend style=" font-size:20px;">Исполнитель:</legend>
									<p>Имя: <?= ($application[1]['user_name'] . " (email: " . $application[1]['email'] . ")") ?? '' ?></p>
									<p>Место работы: <?= ($application[1]['organization'] . "/" . $application[1]['department'] . "/" . $application[1]['address']) ?? '' ?></p>
									<p>Дата создания заявки: <?= ($application[1]['time_change']) ?? '' ?></p>
								</fieldset>
								<?php endif ?>
								<?php endforeach ?>
								<?php if ((int)$currentUser[0]['isAdmin'] == '1') : ?>
									<div class="executor-btn">
										<form method="post">
											<?php if(empty($executerUserId)) : ?>
												<button type="submit" name="link_app" value="link_app">Привязать себя к заявке</button>
												<?php endif?>
											<button type="submit" name="close_app" value="close_app">Закрыть заявку</button>
										</form>
									</div>
								<?php endif ?>
							</div>

						</div>
				
				<div class="conf-button">
					<form method="post">
						<button type="submit" name="edd_message" value="add_message">Добавить сообщение</button>
					</form>

					<?php if ($application[0]['status_user'] == 'Инициатор заявки') : ?>
						<div class="init-btn">
							<button>Одобрить решение</button>
							<button class="reject-btn">Отклонить решение</button>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<?php if ($statusApp[0]['id_status'] == 1) : ?>
		<style>
			.status {
				color: green;
			}
		</style>
	<?php endif ?>