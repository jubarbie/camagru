<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Inscription</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css?<?=time()?>">
</head>

<body>
	<div class="container">
		<?= ($alert) ? '<div class="alert alert-'.$alert['type'].'">'.$alert['msg'].'</div>':''?>
		<form id="login" action="subscribe" method="post">
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
		<div class="align-center">Déjà inscrit ? <a href="login">Se connecter</a></div>
	</div>
</body>
</html>
