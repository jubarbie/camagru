<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Inscription</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/style.css?<?=time()?>">
</head>

<body>
	<header style="margin-top: 100px;">
		<img src="<?=$base_url?>assets/img/logo.jpg" width="310" alt="CAMAGRU" />
	</header>
	<div class="container">
		<?= ($alert) ? '<div class="alert alert-'.$alert['type'].'">'.$alert['msg'].'</div>':''?>
		<form id="login" action="/camagru/login/subscribe" method="post">
			<h1>Inscription</h1>
			<label for="login">Login</label>
			<input type="text" id="login" name="login" value="<?=$login ? $login : ""?>" />
			<label for="pwd">Mot de passe</label>
			<input type="password" id="pwd" name="pwd" />
			<label for="lname">Nom</label>
			<input type="text" id="lname" name="lname" value="<?=$lname ? $lname : ""?>" />
			<label for="fname">Prénom</label>
			<input type="text" id="fname" name="fname" value="<?=$fname ? $fname : ""?>"/>
			<label for="email">Email</label>
			<input type="text" id="email" name="email" value="<?=$email ? $email : ""?>"/>
			<input type="submit" name="submit" value="S'inscrire" />
		</form>
		<div class="align-center">Déjà inscrit ? <a href="<?=$base_url?>login">Se connecter</a></div>
	</div>
</body>
</html>
