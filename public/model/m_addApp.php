<?php
require_once("core/c_addApp.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	// Проверяем, загружен ли файл
	if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK) {
		$fileTmpPath = $_FILES['screenshot']['tmp_name'];
		$fileName = renameFileWithTimestamp($_FILES['screenshot']['name']);
		$fileSize = $_FILES['screenshot']['size'];
		$fileType = $_FILES['screenshot']['type'];

		// Указываем директорию для сохранения
		$uploadFileDir = './src/files/';
		$destPath = $uploadFileDir . $fileName;

		// Перемещаем файл
		if (move_uploaded_file($fileTmpPath, $destPath)) {
			$err = "";
		} else {
			$err = "Ошибка при загрузке файла.";
		}
	} else {
		$err = '';
	}
	// Получаем данные
	$data['title'] = $_POST['title'] ?? '';
	$data['file'] = $fileName;
	$data['text'] = $_POST['message'] ?? '';
	$app_user['id_user'] = $_SESSION['user']['id_user'] ?? '';
}

$id = handleRequestAppAdd($err, $data, $app_user) ?? '';
if($id !== '')
{

}
?>