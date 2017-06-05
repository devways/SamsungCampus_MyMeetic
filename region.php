<?php
require_once "inc/bootstrap.php";
$db = App::getDatabase();
if(isset($_POST['pays'])) {
	$pays = $db->query("SELECT pays_id FROM pays WHERE pays_nom = ?", [htmlspecialchars($_POST['pays'])])->fetch();
	if($pays) {
		$arr = $db->query("SELECT region_nom FROM region WHERE pays_id = ?", [$pays->pays_id])->fetchall();
		echo "<option>region</option>";
		foreach ($arr as $key => $value) {
			echo "<option value=\"" . $value->region_nom . "\">" . $value->region_nom . "</option>";
		}
		exit();
	}
	
}