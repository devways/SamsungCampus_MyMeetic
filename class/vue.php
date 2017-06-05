<?php

class vue {

	static $instance;

	static function getInstance() {
		if(!self::$instance) {
			self::$instance = new vue();
		}
		return self::$instance;
	}

	public function affichage($db, $table, $field) {
		$arr = $db->query("SELECT $field FROM $table")->fetchall();
		foreach ($arr as $key => $value) {
			echo "<option value=\"" . $value->$field . "\">" . $value->$field . "</option>";
		}
	}

	public function affichagePays($db, $table, $field) {
		$arr = $db->query("SELECT $field FROM $table")->fetchall();
		foreach ($arr as $key => $value) {
			if(isset($_SESSION['auth']) && $_SESSION['auth']->pays == $value->$field) {
				echo "<option selected>" . $value->$field . "</option>";
			} else {
				echo "<option>" . $value->$field . "</option>";
			}				
		}
	}

	public function affichageRegion($db, $field) {
		$pays = $db->query("SELECT pays_id FROM pays WHERE pays_nom = ?", [$_SESSION['auth']->pays])->fetch();
		$arr = $db->query("SELECT region_nom FROM region WHERE pays_id = ?", [$pays->pays_id])->fetchall();
		foreach ($arr as $key => $value) {
			if(isset($_SESSION['auth']) && $_SESSION['auth']->region == $value->$field) {
				echo "<option selected>" . $value->$field . "</option>";
			} else {
				echo "<option>" . $value->$field . "</option>";
			}
		}
	}

	public function affichageDepartement($db, $field) {
		$region = $db->query("SELECT region_id FROM region WHERE region_nom = ?", [$_SESSION['auth']->region])->fetch();
		$arr = $db->query("SELECT departement_nom FROM departement WHERE region_id = ?", [$region->region_id])->fetchall();
		foreach ($arr as $key => $value) {
			if(isset($_SESSION['auth']) && $_SESSION['auth']->departement == $value->$field) {
				echo "<option selected>" . $value->$field . "</option>";
			} else {
				echo "<option>" . $value->$field . "</option>";
			}
		}
	}

	public function affichageVille($db, $field) {
		$departement = $db->query("SELECT departement_id FROM departement WHERE departement_nom = ?", [$_SESSION['auth']->departement])->fetch();
	$arr = $db->query("SELECT ville_nom FROM villes WHERE departement_id = ?", [$departement->departement_id])->fetchall();
		foreach ($arr as $key => $value) {
			if(isset($_SESSION['auth']) && $_SESSION['auth']->ville == $value->$field) {
				echo "<option selected>" . $value->$field . "</option>";
			} else {
				echo "<option>" . $value->$field . "</option>";
			}
		}
	}

	public function jour() {
		echo "<option>jour</option>";
		for ($i = 1; $i < 32; $i++) {
			if(isset($_SESSION['auth']) && substr($_SESSION['auth']->date, 8, 2) == $i) {
				echo "<option selected>" . $i . "</option>";
			} else {
				echo "<option>" . $i . "</option>";
			}
		}
	}

	public function mois() {
		echo "<option>mois</option>";
		for ($i = 1; $i < 13; $i++) {
			if(isset($_SESSION['auth']) && substr($_SESSION['auth']->date, 5, 2) == $i) {
				echo "<option selected>" . $i . "</option>";
			}
			echo "<option>" . $i . "</option>";
		}
	}

	public function annee() {
		echo "<option>annee</option>";
		for ($i = 2017; $i > 1899; $i--) {
			if(isset($_SESSION['auth']) && substr($_SESSION['auth']->date, 0, 4) == $i) {
				echo "<option selected>" . $i . "</option>";
			} else {
				echo "<option>" . $i . "</option>";
			}
			
		}
	}

	public function genre() {
		echo "<option disabled>Genre</option>";
		if(isset($_SESSION['auth']) && $_SESSION['auth']->sex == "homme") {;
			echo "<option selected>homme</option>";
		} else {
			echo "<option>homme</option>";
		}
		if(isset($_SESSION['auth']) && $_SESSION['auth']->sex == "femme") {
			echo "<option selected>femme</option>";
		} else {
			echo "<option>femme</option>";
		}
		if(isset($_SESSION['auth']) && $_SESSION['auth']->sex == "autre") {
			echo "<option selected>autre</option>";
		} else {
			echo "<option>autre</option>";
		}
	}

	public function affichageGenre() {	
		echo "<option>homme</option>";
		echo "<option>femme</option>";
		echo "<option>autre</option>";
	}

	public function affichageAge($date) {
		$date = explode("-", $date);
		$jour = date("j") - $date[2];
		$mois = date("n") - $date[1];
		$annee = date("Y") - $date[0] - 1;
		if($mois > 0) {
			return $annee - 1;
		} elseif ($mois < 0) {
			return $annee;
		} else {
			if($jour >= 0) {
				return $annee;
			}
			return $annee - 1;
		}
	}

	public function afficheContact($db){
		$contact = $db->query("SELECT * FROM users WHERE username LIKE  \"%%\" AND id != ?", [$_SESSION['auth']->id])->fetchall();
		if($contact) {
			foreach ($contact as $key => $value) {
				echo "<div id=\"" . $value->id . "\" onclick=\"discution(document.getElementById('" . $value->id . "').id)\" style=\"background-color: #FFEFF2; cursor: pointer;\">";
				echo "<p>" . $value->username . "</p>";
				echo "<p>" . $value->sex . "     " . $this->affichageAge($value->date) . 'ans' . "</p>";
				echo "<p>" . $value->ville . "</p>";
				echo "</div>";
			}
		}
	}
	
}