	<?php
    require_once("template/header.php");
    ?>
	
	<?php
    if (isset($_POST['save-btn'])) : ?>
        <?php require_once("model/m_addApp.php"); ?>
    <?php  else : ?>
        <div class="content-application">
	    <div class="application">
	        <form id="messageForm" class="form-app" method="POST" enctype="multipart/form-data">
	            <div class="application-content">
	                <div class="content-title">
	                    <input class="app-input" type="text" placeholder="Введите тему обращения" name="title" required>
	                </div>
	                <div class="content-message">
	                    <textarea name="message" placeholder="Введите ваше сообщение..." rows="5" required></textarea>
	                </div>
	                <div class="content-file">
	                    <input type="file" name="screenshot" accept="image/*">
	                </div>
	                <div class="content-button">
	                    <div class="content-btn">
	                        <button class="save-btn" type="submit" name="save-btn">Отправить</button>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	    <div class="application-conf">
	        <div class="conf-app">
	        </div>

	    </div>
	</div>
   <?php endif ?>
	<div class=""><?= $id ?? ''; ?></div>
	<div class="footer"></div>
	</div>
	<style>
	    .content-application {
	        padding-top: 200px;
	    }
	</style>