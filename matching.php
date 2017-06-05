<?php 
require_once 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
$vue = new vue();
$search = new search($_POST);

?>
<?php require_once 'inc/header.php';?>

<form method="post">
	<div class="form-group col-md-2">
		<label>sexe</label>
		<select name="sex[]" class="selectpicker col-md-12" multiple>
			<?php $vue->affichageGenre(); ?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label>pays</label>
		<select id="pays" name="pays_nom[]" class="selectpicker col-md-12" multiple>
			<?php $vue->affichage($db, "pays", "pays_nom"); ?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label>region</label>
		<select id="region" name="region_nom[]" class="selectpicker col-md-12" multiple>
			<?php $vue->affichage($db, "region", "region_nom"); ?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label>departement</label>
		<select id="departement" name="departement_nom[]" class="selectpicker col-md-12" multiple>
			<?php $vue->affichage($db, "departement", "departement_nom"); ?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label>ville</label>
		<select id="ville" name="ville_nom[]" multiple class="selectpicker col-md-12" >
			<?php $vue->affichage($db, "villes", "ville_nom"); ?>
		</select>
	</div>
	<div class="form-group col-md-2">
		<label>age</label>
		<select id="age" name="age[]" class="selectpicker col-md-12" multiple>
			<option>18/25</option>
			<option>25/35</option>
			<option>35/45</option>
			<option>45+</option>
		</select>
	</div>
	<button type="submit" class="btn btn-danger btn-lg btn-block" style="background-color: hotpink;">Rechercher</button>
</form>
<div>
	<?php 
		echo "<div>";
		foreach ($search->search($db, 'sex', 'pays_nom', 'region_nom', 'departement_nom', 'ville_nom', 'age') as $key => $val) {
				echo "<div style=\"border: 1px solid black\" class=\"palPink\">";
				echo "<p> Username : " . $val->username . "</p>";
				echo "<p> Age : " . $vue->affichageAge($val->date) . "ans</p>";
				echo "<p> Genre : " . $val->sex . "</p>";
				echo "<p> Pays : " . $val->pays . "</p>";
				echo "<p> Region : " . $val->region . "</p>";
				echo "<p> Departement : " . $val->departement . "</p>";
				echo "<p> Ville : " . $val->ville . "</p>";
				echo "</div>";
		}
		echo "</div>";
	?>
</div>
<?php require_once 'inc/footer.php' ?>