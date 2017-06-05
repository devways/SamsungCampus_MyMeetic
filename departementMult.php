<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
if(isset($_POST['pays'])) {
	$pays = htmlspecialchars($_POST['pays']);
	$req = "SELECT id_pays FROM pays WHERE pays_nom = $pays[0]";

	foreach($pays as $key => $val) {
		$req .= " OR pays_nom = $val";
	}
	$pays = $db->query($req)->fetchall();
	$req = "SELECT departement_nom FROM departement WHERE id_pays = $pays->id_pays";
	foreach ($pays as $key => $value) {
		$req .= " OR id_pays = $value->id_pays";
	}
	$arr = $db->query($req)->fetchall();
	foreach ($arr as $key => $value) {
		echo "<option value=\"" . $value->departement_nom . "\">" . $value->departement_nom . "</option>";
	}
	exit();
}