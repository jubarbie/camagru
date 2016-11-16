<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="/camagru/assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="/camagru/assets/css/style.css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</head>

<body>

<nav>
	<ul>
		<li><a href="/camagru/user"><i class="fa fa-user" aria-hidden="true"></i></a></li>
		<li><a href="/camagru/"><i class="fa fa-camera" aria-hidden="true"></i></a></li>
		<li><a href="/camagru/galery/page/1"><i class="fa fa-photo" aria-hidden="true"></i></a></li>
		<li id="logout"><a href="/camagru/login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
	</ul>
</nav>

<?= ($alert) ? "<div class='alert alert-".$alert['type']."'>".$alert['msg']."</div>" : ""?>

