<?php 
require_once 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
$vue = new vue();
if(!empty($_POST)) {
	$errors = array();

	$db = App::getDatabase();
	$validator = new Validator($_POST);
	$validator->isAlphaNum("username","Votre pseudo n'est pas valide");
	$validator->isEmail("email","Votre email n'est pas valide");
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
	$validator->isConfirmedUp("password", "Votre mot de passe n'est pas valide");
	$errors = $validator->getErrors();
	if($validator->isValid()) {
		$auth->update($db, htmlspecialchars($_POST['username']),
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
		$session->setFlash('success',"Vos modif on bien ete pris en conte");
		$session = Session::getInstance();
		if($auth->delete($db, $_POST['submit'])) {
			App::redirection('login.php');	
		}
		App::redirection('account.php');
	} else {
		$errors = $validator->getErrors();
	}
}
?>
<?php require_once 'inc/header.php'; ?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>
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
<div id="Fromulaire">
	<form action="#" method="post" id="pass">
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="text" name="username" value="<?= $_SESSION['auth']->username ?>">
		</div>
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="text" name="firstname" value="<?= $_SESSION['auth']->firstname ?>">
		</div>
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="text" name="lastname" value="<?= $_SESSION['auth']->lastname ?>">
		</div>
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="email" name="email" value="<?= $_SESSION['auth']->email ?>">
		</div>
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="password" name="password" placeholder="entrez votre nouveau mot de passe">
		</div>
		<div class="form-group">
			<input class="form-control" style="background-color: #FFE3E8;" type="password" name="password_confirm" placeholder="confirmer le nouveau mot de passe">
		</div>
		<div class="form-group row col-md-12">
			<label>sexe</label>
			<select name="sex" class="form-control" style="background-color: #FFE3E8;">
				<?php $vue->genre(); ?>
			</select>
		</div>
		<div class="form-group row col-md-12">
			<label class="col-md-12">date de naissance</label>
			<select name="jour" class="selectpicker col-md-3" style="background-color: #FFE3E8;">
				<?php $vue->jour(); ?>
			</select>
			<select name="mois" class="selectpicker col-md-3" style="background-color: #FFE3E8;">
				<?php $vue->mois(); ?>
			</select>
			<select name="annee" class="selectpicker col-md-3" style="background-color: #FFE3E8;">
				<?php $vue->annee(); ?>
			</select>
		</div>
		<div class="form-group row col-md-12">
			<label>pays</label>
			<select id="pays" name="pays_nom" class="form-control" style="background-color: #FFE3E8;" onchange="ajax_region(this.value);">
				<option>pays</option>
				<?php $vue->affichagePays($db, "pays", "pays_nom"); ?>
			</select>
		</div>
		<div class="form-group row col-md-12">
			<label>departement</label>
			<select id="region" name="region_nom" class="form-control" style="background-color: #FFE3E8;" onchange="ajax_departement(this.value)">
				<?php $vue->affichageRegion($db, "region_nom"); ?>
			</select>
		</div>
		<div class="form-group row col-md-12">
			<label>departement</label>
			<select id="departement" name="departement_nom" class="form-control" style="background-color: #FFE3E8;" onchange="ajax_ville(this.value)">
				<?php $vue->affichageDepartement($db, "departement_nom"); ?>
			</select>
		</div>
		<div class="form-group row col-md-12">
			<label>ville</label>
			<select id="ville" name="ville_nom" style="background-color: #FFE3E8;" class="form-control">
				<?php $vue->affichageVille($db, "ville_nom"); ?>
			</select>
		</div>
		<button type="submit" class="btn btn-primary" name="submit" value="1" style="background-color: hotpink;">Mettre a jour</button>
		<button type="submit" class="btn btn-danger" name="submit" value="0" >Suprimer mon compte</button>
	</form>
</div>
<?php require_once 'inc/footer.php'; ?>