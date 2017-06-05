<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
if(isset($_POST['departement'])) {
	$departement = $db->query("SELECT departement_id FROM departement WHERE departement_nom = ?", [htmlspecialchars($_POST['departement'])])->fetch();
	if($departement) {
		$arr = $db->query("SELECT ville_nom FROM villes WHERE departement_id = ?", [$departement->departement_id])->fetchall();
		echo "<option>ville</option>";
		foreach ($arr as $key => $value) {
			echo "<option>" . $value->ville_nom . "</option>";
		}
		exit();
	}
	
}