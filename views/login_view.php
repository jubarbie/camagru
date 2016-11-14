<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - login</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css?<?=time()?>">
</head>

<body>
	<div class="container">
		<?= ($alert) ? '<div class="alert alert-'.$alert['type'].'">'.$alert['msg'].'</div>':''?>
		<form id="login" action="index.php" method="post">
			<h1>Connection</h1>
			<label for="login">Login</label>
			<input type="text" id="login" name="login" value="<?=$login ? $login : ""?>" />
			<label for="pwd">Mot de passe</label>
			<input type="password" id="pwd" name="pwd" />
			<input type="submit" name="submit" value="Se connecter" />
		</form>
		<div class="align-center">Nouveau? <a href="subscribe">Inscription</a></div>
	</div>
</body>
</html>
