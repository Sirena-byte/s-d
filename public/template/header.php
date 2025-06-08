<?php
ob_start(); // Начинаем буферизацию вывода
require_once('model/m_autorization.php'); ?>
<div class="header">
	<div class="logo">
		<p>HD</p>
		<span>support</span>
	</div>
	<ul class="menu">
		<?php if ($_SESSION['user']['isAdmin'] == 1) : ?>
			<li class="item-menu dropdown">
				<div class="menu-item">
					<img src="src/icon/settings.png" alt="">
					<p>Администрирование</p>
				</div>
				<ul class="sub-item">
					<li class="item">Пользователи
						<ul class="sub-sub-item">
							<li><a href="?page=allUsers">Список</a></li>
							<li><a href="?page=addUser" class="">Создать</a></li>
						</ul>
					</li>

				</ul>
			</li>
		<?php endif; ?>
		<li class="item-menu dropdown">
			<div class="menu-item">
				<img src="src/icon/support2.png" alt="">
				<p>Поддержка</p>
			</div>
			<ul class="sub-item">
				<li class="item">Заявки
					<ul class="sub-sub-item">
						<?php if ($_SESSION['user']['isAdmin'] == 1) : ?>
							<li><a href="?page=allApp">Все заявки</a></li>
							<li><a href="?page=allApp">Статистика</a></li>
							<?php endif; ?>
						<?php if($_SESSION['user']['isAdmin'] == 0) : ?>
							<li><a href="?page=addApp">Создать</a></li>
						<?php endif; ?>
						
					</ul>
				</li>
				<li class="item">пункт 2
					<ul class="sub-sub-item">
						<li>пункт 2-1</li>
						<li>пункт 2-2</li>
						<li>пункт 2-3</li>
					</ul>
				</li>
				<li class="item">пункт 3
					<ul class="sub-sub-item">
						<li>пункт 3-1</li>
						<li>пункт 3-2</li>
						<li>пункт 3-3</li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="item-menu dropdown">
			<div class="menu-item">
				<img src="src/icon/knowlege2.png" alt="">
				<p>База знаний</p>
			</div>
			<ul class="sub-item">
				<li class="item">пункт 1
					<ul class="sub-sub-item">
						<li>пункт 1-1</li>
						<li>пункт 1-2</li>
						<li>пункт 1-3</li>
					</ul>
				</li>
				<li class="item">пункт 2
					<ul class="sub-sub-item">
						<li>пункт 2-1</li>
						<li>пункт 2-2</li>
						<li>пункт 2-3</li>
					</ul>
				</li>
				<li class="item">пункт 3
					<ul class="sub-sub-item">
						<li>пункт 3-1</li>
						<li>пункт 3-2</li>
						<li>пункт 3-3</li>
					</ul>
				</li>
			</ul>
		</li>
		<li class="item-menu dropdown">
			<div class="menu-item">
				<img src="src/icon/user.png" alt="">
				<p>
					<?= $_SESSION['user']['name'] ?? 'Личный кабинет' ?>
				</p>
			</div>
			<ul class="sub-item">
				<li class="item"><a href="?page=autorization">Выйти</a></li>
				<li class="item">Настройки</li>
			</ul>
		</li>
	</ul>
</div>
<?php ob_end_flush(); // Отправляем буфер 
?>