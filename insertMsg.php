<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
$auth = App::getAuth();
$session = Session::getInstance();
$vue = new vue();

if(isset($_POST['Msg'])) {
	$db->query("INSERT INTO messages (id_expediteur, name_expediteur, message, id_destinataire) VALUES 
		(?, ?, ?, ?)", [$_SESSION['auth']->id, $_SESSION['auth']->username, htmlspecialchars($_POST['Msg']), $_SESSION['dest']]);
	echo "<div class=\"form-group col-md-9\">";
	echo "<textarea id=\"area\" class=\"form-control\" rows=\"3\" style=\"background-color: #FFE3E8;\">";
	echo "</textarea>";
	echo "</div>";
	echo "<div name=\"submit\" class=\"col-md-3\" onclick=\"insertMsg($('#area').val())\" style=\"background-color: hotpink; color: white; cursor: pointer;\">envoyer</div>";
		exit();
}