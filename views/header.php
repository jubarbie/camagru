<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/style.css?<?=time()?>" />
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>

<body>

<nav>
	<ul>
		<li><a href="<?=$base_url?>user"><i class="fa fa-user" aria-hidden="true"></i></a></li>
		<li><a href="<?=$base_url?>"><i class="fa fa-camera" aria-hidden="true"></i></a></li>
		<li><a href="<?=$base_url?>galery/page/1"><i class="fa fa-photo" aria-hidden="true"></i></a></li>
		<li id="logout"><a href="<?=$base_url?>login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
	</ul>
</nav>

<?= ($alert) ? "<div class='alert alert-".$alert['type']."'>".$alert['msg']."</div>" : ""?>

