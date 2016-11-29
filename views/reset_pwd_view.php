<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - login</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/style.css?<?=time()?>">
</head>

<body>
	<header style="margin-top: 100px;">
		<img src="<?=$base_url?>assets/img/logo.jpg" width="310" alt="CAMAGRU" />
	</header>
	<div class="container">
		<?= ($alert) ? '<div class="alert alert-'.$alert['type'].'">'.$alert['msg'].'</div>':''?>
		<form id="login" action="<?=$base_url?>login/reset_pwd" method="post">
			<h1>Réinitialisation du mot de passe</h1>
			<p>Tape ton login et nous t'enverrons un email avec un nouveau mot de passe</p>
			<label for="login">Login</label>
			<input type="text" id="login" name="login" value="<?=$login ? $login : ""?>" />
			<input type="submit" name="submit" value="Valider" />
		</form>
		<div class="align-center">Nouveau? <a href="<?=$base_url?>login/subscribe">Inscription</a></div>
		<div class="align-center"><small><a href="<?=$base_url?>login/reset_pwd">Mot de passe oublié ?</a></small></div>
	</div>
	<div class="container">
		<div id="footer">
			<small>jubarbie - 2016</small>
		</div>
	</div>
</body>
</html>
