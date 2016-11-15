<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="/camagru/assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/camagru/assets/css/style.css" />
</head>

<body>

<nav>
	<ul>
		<li id="logout"><a href="/camagru/login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
	</ul>
</nav>

<?= ($alert) ? "<div class='alert alert-".$alert['type']."'>".$alert['msg']."</div>" : ""?>

