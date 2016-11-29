<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>assets/css/style.css?<?=time()?>" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>

<body>

<header class="gr-bg">
	<?= ($alert) ? "<div class='alert alert-".$alert['type']."'>".$alert['msg']."</div>" : ""?>
	<div class="container">
		<nav>
			<ul class="pull-right">
				<li><a href="<?=$base_url?>user"><i class="fa fa-user-circle" aria-hidden="true"></i></a></li>
				<li><a href="<?=$base_url?>login/logout"><i class="fa fa-power-off" aria-hidden="true"></i></a></li>
			</ul>
		</nav>
	<div class="container">
	
	<div class="container">
		<div class="content" id="head">
			<a href="<?=$base_url?>"><img src="<?=$base_url?>assets/img/logo.jpg" alt="Camagru" width="200" /></a>
			<ul class="inline-block pull-right">
				<li id="menu-photo"><a href="<?=$base_url?>"></a></li>
				<li id="menu-gal"><a href="<?=$base_url?>galery/page/1"></a></li>
			</ul>
		</div>
	</div>
</header>

