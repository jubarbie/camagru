<?php
require_once('models/users_model.php');

function check_pwd($pwd)
{
	if (preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{6}$/", $pwd))
		return hash('whirlpool', $pwd);
	else
		return (FALSE);
}

if (!$_POST['submit'])
	include('views/subscribe_view.php');
else
{
	$login = $_POST['login'];
	$pwd = $_POST['pwd'];
	$lname = $_POST['lname'];
	$fname = $_POST['fname'];
	$email = $_POST['email'];
	if (!$login || !$pwd || !$lname || !$fname || !$email)
	{
		$alert['type'] = 'danger';
		$alert['msg'] = 'Tous les champs sont requis';
		include('views/subscribe_view.php');
	}
	else
	{
		if (!($pwd = check_pwd($pwd)))
		{
			$alert['type'] = 'danger';
			$alert['msg'] = 'Le mot de passe n\'est pas assez fort';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$alert['type'] = 'danger';
			$alert['msg'] = 'L\'email n\'est pas valide';
		}
		if ($login && $pwd && $lname && $fname && $email)
		{
			if (add_user($login, $pwd, $email, $lname, $fname))
			{
				$alert['type'] = 'success';
				$alert['msg'] = 'Vous avez bien été inscrit, vérifiez votre boîte mail';
				mail($email, "Camagru - Validation de l'incription", "Pour valider votre inscription merci de <a href='localhost:8080/camagru'>'suivre ce lien</a>");
				include('views/login_view.php');
			}
			else
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Un problème est survenu';
				include('views/subscribe_view.php');
			}
		}
		else
			include('views/subscribe_view.php');

	}
}
