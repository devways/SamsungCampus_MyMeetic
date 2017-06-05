<?php
require_once 'inc/bootstrap.php';
Session::getInstance();
$vue = new vue();
$db = App::getDatabase();
if(isset($_SESSION["auth"])){
	header('Location: account.php');
}
if(!empty($_POST)) {
	$errors = array();

	$validator = new Validator($_POST);
	$validator->isAlphaNum("username","Votre pseudo n'est pas valide");
	if($validator->isValid()){
		$validator->isUnic("username", "users", $db, "Ce pseudo est deja pris");
	}
	$validator->isEmail("email","Votre email n'est pas valide");
	if($validator->isValid()){
		$validator->isUnic("email", "users", $db, "Cette email est deja pris");
	}
	$validator->isDay("jour", "votre jour de naissance nest pas valide");
	$validator->isMonth("mois", "votre mois de naissance nest pas valide");
	$validator->isYears("annee", "votre annee de naissance nest pas valide");
	if($validator->isValid()){
		$validator->isMajer("jour", "mois", "annee", "Vous etes pas majeur");
	}
	$validator->isGenre("sex", "votre genre est bizzare");
	$validator->isCountry($db, "pays_nom", "votre genre est bizzare");
	$validator->isRegion($db, "departement_nom", "votre genre est bizzare");
	$validator->isCity($db, "ville_nom", "votre genre est bizzare");
	$validator->isAlpha("lastname","Votre nom n'est pas valide");
	$validator->isAlpha("firstname","Votre prenom n'est pas valide");
	$validator->isConfirmed("password", "Votre mot de passe n'est pas valide");

	if($validator->isValid()) {
		App::getAuth()->register($db, htmlspecialchars($_POST['username']),
									htmlspecialchars($_POST['lastname']),
									htmlspecialchars($_POST['firstname']),
									htmlspecialchars($_POST['email']),
									htmlspecialchars($_POST['password']),
									htmlspecialchars($_POST['jour']),
									htmlspecialchars($_POST['mois']),
									htmlspecialchars($_POST['annee']), 
									htmlspecialchars($_POST['sex']),
									htmlspecialchars($_POST['ville_nom']),
									htmlspecialchars($_POST['departement_nom']),
									htmlspecialchars($_POST['region_nom']),
									htmlspecialchars($_POST['pays_nom']));
		Session::getInstance()->setFlash('success',"un email de confirmation vous a ete envoyer");
		App::redirection('login.php');
	} else {
		$errors = $validator->getErrors();
	}
}

?>
<?php require 'inc/header.php' ?>

<h1>S'inscrire</h1>

<?php if (!empty($errors)): ?>
	<div class="alert alert-danger">
		<p>Vous n'avez pas remplis le formulaire correctement</p>
		<ul>
			<?php foreach($errors as $error): ?>
				<li><?= $error; ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>

<form action="#" method="POST">
	<div class="form-group row col-md-12" >
		<label>Pseudo</label>
		<input type="text" name="username" class="form-control" style="background-color: #FFE3E8;"/>
	</div>
	<div class="form-group row col-md-12">
		<label>nom</label>
		<input type="text" name="lastname" class="form-control" style="background-color: #FFE3E8;"/>
	</div>
	<div class="form-group row col-md-12">
		<label>prenom</label>
		<input type="text" name="firstname" class="form-control" style="background-color: #FFE3E8;"/>
	</div>
	<div class="form-group row col-md-12">
		<label>email</label>
		<input type="text" name="email" class="form-control" style="background-color: #FFE3E8;"/>
	</div>
	<div class="form-group row col-md-12">
		<label>sexe</label>
		<select name="sex" class="form-control" style="background-color: #FFE3E8;">
			<?php $vue->genre(); ?>
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label class="col-md-12">date de naissance</label>
		<select name="jour" class="selectpicker col-md-3">
			<?php $vue->jour(); ?>
		</select>
		<select name="mois" class="selectpicker col-md-3">
			<?php $vue->mois(); ?>
		</select>
		<select name="annee" class="selectpicker col-md-3">
			<?php $vue->annee(); ?>
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label>pays</label>
		<select id="pays" name="pays_nom" class="form-control" onchange="ajax_region(this.value)" style="background-color: #FFE3E8;">
			<option>pays</option>
			<?php $vue->affichage($db, "pays", "pays_nom"); ?>
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label>region</label>
		<select id="region" name="region_nom" class="form-control" onchange="ajax_departement(this.value)" style="background-color: #FFE3E8;">
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label>departement</label>
		<select id="departement" name="departement_nom" class="form-control" onchange="ajax_ville(this.value)" style="background-color: #FFE3E8;">
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label>ville</label>
		<select id="ville" name="ville_nom" class="form-control" style="background-color: #FFE3E8;">
		</select>
	</div>
	<div class="form-group row col-md-12">
		<label>Mot de passe</label>
		<input type="password" name="password" class="form-control" style="background-color: #FFE3E8;"/>
	</div>
	<div class="form-group row col-md-12">
		<label>Confirmez votre mot de passe</label>
		<input type="password" name="password_confirm" class="form-control" style="background-color: #FFE3E8;"/>
	</div>

	<button type="submit" class="btn btn-primary" style="background-color: hotpink;">M'inscrire</button>
</form>

<?php require 'inc/footer.php' ?>