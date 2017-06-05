<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
$vue = new vue();
if(isset($_POST['contact'])) {
	$contact = $db->query("SELECT * FROM users WHERE username LIKE  \"%" . htmlspecialchars($_POST['contact']) . "%\" AND id != ?", [$_SESSION['auth']->id])->fetchall();
	if($contact) {
		foreach ($contact as $key => $value) {
			echo "<div id=\"" . $value->id . "\" onclick=\"discution(document.getElementById('" . $value->id . "').id)\" style=\"background-color: #FFEFF2; cursor: pointer;\">";
			echo "<p>" . $value->username . "</p>";
			echo "<p>" . $value->sex . "     " . $vue->affichageAge($value->date) . 'ans' . "</p>";
			echo "<p>" . $value->ville . "</p>";
			echo "</div>";
		}
		exit();
	}
}