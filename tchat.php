<?php 
require_once 'inc/bootstrap.php';
$db = App::getDatabase();
$auth = App::getAuth();
$auth->restrict();
$session = Session::getInstance();
$vue = new vue();
$search = new search($_POST);

?>
<?php require_once 'inc/header.php'; ?>

	<div class="col-md-3" id="left">
		<form id="tchat" onsubmit="return false">
			<div class="form-group">
				<label>Pseudo</label>
				<input type="text" name="pseudo" id="form_pseudo" class="form-control" style="background-color: #FFE3E8;" autocomplete="off" onkeyup="search_contact(this.value)" />
			</div>
		</form>
		<div id="contact" class="palPink">
		<?php $vue->afficheContact($db); ?>
		</div>
	</div>

	<div id="right" class="col-md-9">
		<div id="message" class="palPink">
			
		</div>
		<form id="form">
			<div class="form-group col-md-9">
				<textarea id="area" class="form-control" style="background-color: #FFE3E8;" rows="3"></textarea>
			</div>
			<div class="col-md-3" style="background-color: hotpink; color: white; cursor: pointer;" onclick="insertMsg($('#area').val())">envoyer</div>
		</form>
	</div>

<?php require_once 'inc/footer.php'; ?>