<?php
require_once('models/users_model.php');

if (!$_POST['submit'] || !$_POST['login'] || !$_POST['pwd'])
	include('views/login_view.php');
else
{
	$login = $_POST['login'];
	$pwd = $_POST['pwd'];
	$result = login($login, $pwd);
	if ($result)
	{
		$alert['type'] = 'success';
		$alert['msg'] = 'Connection réussie';
		include('views/header.php');
		include('views/home_view.php');
		include('views/footer.php');
	}
	else
	{
		$alert['type'] = 'danger';
		$alert['msg'] = 'Login ou mot de passe incorrect';
		include('views/login_view.php');
	}
}
