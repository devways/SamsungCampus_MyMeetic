<?php
require_once 'Bootstrap.php';
Session::getInstance();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="icon" href="../../favicon.ico">
    <script type="text/javascript" src="inc/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="ajax/ajax.js"></script>
    <script type="text/javascript" src="ajax/script.js"></script>

    <title>Mon super projet</title>

    <!-- Bootstrap core CSS -->
    <link href="css/app.css" rel="stylesheet">
  </head>

  <body style="background-color: pink;">

    <nav class="navbar navbar-inverse" style="background-color: hotpink;">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <?php if(isset($_SESSION['auth'])): ?>
            <li><a href="matching.php">rencontres</a></li>
            <li><a href="tchat.php">messagerie</a></li>
            <li><a href="account.php">profil</a></li>
            <li><a href="logout.php">Se deconecter</a></li>
          <?php else: ?>
            <li><a href="register.php">S'inscrire</a></li>
            <li><a href="login.php">Se connecter</a></li>
          <?php endif; ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
    <?php if(Session::getInstance()->hasFlash()): ?>
      <?php foreach(Session::getInstance()->getFlash() as $type => $message): ?>
        <div class="alert alert-<?= $type; ?>">
          <?= $message; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
