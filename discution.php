<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
$vue = new vue();
if(isset($_POST['contact']) || isset($_SESSION['dest'])) {
	if(isset($_POST['contact'])) {
		$_SESSION['dest'] = htmlspecialchars($_POST['contact']);
		$id_contact = htmlspecialchars($_POST['contact']);
	} else {
		$id_contact = $_SESSION['dest'];
	}
	
	$contact = $db->query("SELECT * FROM messages WHERE (id_destinataire = ? AND id_expediteur = ?) OR (id_destinataire = ? AND id_expediteur = ? AND active = 1) ORDER BY date DESC", [$id_contact, $_SESSION['auth']->id, $_SESSION['auth']->id, $id_contact])->fetchall();
	if($contact) {
		foreach ($contact as $key => $value) {
			if ($value->id_expediteur == $_SESSION['auth']->id && $value->active == 1) {
				echo "<div class=\"expe\">";
				echo "<p>" . $value->name_expediteur . "</p>";
				echo "<p>" . $value->date . "</p>";
				echo "<p>" . $value->message . "</p>";
				echo "<p onclick=\"deletMsg('" . $value->id . "')\" title=\"suprimer ce message\" style=\"background-color: hotpink; color: white; width: 25px; height: 25px; text-align: center; cursor: pointer;\">x</p>";
				echo "</div>";	
			} elseif($value->id_expediteur == $_SESSION['auth']->id && $value->active == 0) {
				echo "<div class=\"expe\">";
				echo "<p>" . $value->name_expediteur . "</p>";
				echo "<p>" . $value->date . "</p>";
				echo "<p>" . $value->message . "</p>";
				echo "<p>" . "<i>Ce message a ete suprimer</i>" . "</p>";
				echo "</div>";	
			} else {
				echo "<div class=\"desti\">";
				echo "<p>" . $value->name_expediteur . "</p>";
				echo "<p>" . $value->date . "</p>";
				echo "<p>" . $value->message . "</p>";
				echo "</div>";	
			}
		}
		exit();
	}
}