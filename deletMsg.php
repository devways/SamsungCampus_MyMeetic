<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
$auth = App::getAuth();
$session = Session::getInstance();
$vue = new vue();

if(isset($_POST['Msg'])) {
	$db->query("UPDATE messages SET active = 0 WHERE id = ? AND id_expediteur = ?", [htmlspecialchars($_POST['Msg']), $_SESSION['auth']->id]);
		exit();
}