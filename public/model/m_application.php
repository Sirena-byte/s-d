<?php require_once("core/c_addApp.php");
require_once("core/c_application.php");

if ($_GET['id'] !== '') {
	$idCurrentApp = (int)$_GET['id'] ?? '';
	$application = getApplicationOnId((int)$_GET['id']) ?? '';
	$statusApp = getStatusApp($_GET['id']) ?? '';
	$messages = getMessagesOnIdApp($_GET['id']);
	$currentUser = getUseronID($_SESSION['user']['id_user'] ?? '');
	$initUserId = getIDUserLinkApp($idCurrentApp, 1) ?? '';
	$executerUserId = getIDUserLinkApp($idCurrentApp,  '2') ?? '';
	$idInitApp = getIdInitionApp($idCurrentApp) ?? '';
	//print_r($application);
} else {
	echo "no id";
}
$data = [];
if (isset($_POST)) {
	if (isset($_POST['submit_message'])) {
		if (($_POST['message']) !== '') {
			$data['text'] = $_POST['message'] ?? '';
			$data['id_app'] = (int)$_GET['id'];
			$data['id_user'] = (int)$currentUser[0]['id_user'];
			handleRequestAddMessage('', $data);
			//$messages = getMessagesOnIdApp($GET['id']);
			$path = "Location: ?page=application&id=" . $data['id_app'];
			header($path);
			exit();
		} else {
			echo "сообщения нет";
			$_GET['message']['info'] = 'submit no';
		}
	} else {
		$_GET['message']['info'] = 'no';
	}
}

if (isset($_POST)) {
	if (isset($_POST['close_app'])) {
		$dataAppClose['id_status'] = 4;
		$dataAppClose['id_app'] = $idCurrentApp;
		changeStatusApp($dataAppClose);
		$path = "Location: ?page=application&id=" . $idCurrentApp;
		header($path);
		exit();
	}

	if (isset($_POST['approve'])) {
		$dataApp['id_status'] = 3;
		$dataApp['id_app'] = $idCurrentApp;
		changeStatusApp($dataApp);
		$path = "Location: ?page=application&id=" . $idCurrentApp;
		header($path);
		exit();
	}
	if (isset($_POST['reject'])) {
		$dataAppReject['id_status'] = 2;
		$dataAppReject['id_app'] = $idCurrentApp;
		changeStatusApp($dataAppReject);
		$path = "Location: ?page=application&id=" . $idCurrentApp;
		header($path);
		exit();
	}
}

if (!empty($initUserId)) {
	$userInit = getUseronID($initUserId); //получили инициатора
} else {
	//echo "инициатора нет";
}
if (!empty($executerUserId)) {
	$userExecute = getUseronID($executerUserId);
} else {
	//echo "исполнителя нет";
}
if (!empty($_POST['link_app'])) {
	echo "нажата кнопка связи с заявкой";
	$dataLink['id_user'] = $currentUser[0]['id_user'];
	$dataLink['id_app'] = $idCurrentApp;
	$dataLink['id_user_status'] = 2;
	handleRequestAddLinkToApp('', $dataLink);
	$path = "Location: ?page=application&id=" . $dataLink['id_app'];
	header($path);
	exit();
} else {
	//echo "кнопка не нажата";
}
