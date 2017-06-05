<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
if(isset($_POST['region'])) {
	$region = $db->query("SELECT region_id FROM region WHERE region_nom = ?", [htmlspecialchars($_POST['region'])])->fetch();
	if($region) {
		$arr = $db->query("SELECT departement_nom FROM departement WHERE region_id = ?", [$region->region_id])->fetchall();
		echo "<option>departement</option>";
		foreach ($arr as $key => $value) {
			echo "<option value=\"" . $value->departement_nom . "\">" . $value->departement_nom . "</option>";
		}
		exit();
	}
}