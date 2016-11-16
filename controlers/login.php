<?php
session_start();
Class Login 
{
	function __construct() 
	{
		require_once('models/users_model.php');
	}

	public function index() 
	{
		global $users_model;
		global $URL;
		
		if (!$_POST['submit'] || !$_POST['login'] || !$_POST['pwd'])
			include('views/login_view.php');
		else
		{
			$login = $_POST['login'];
			$pwd = $_POST['pwd'];
			$result = $users_model->login($login, $pwd);
			if ($result)
			{
				$alert['type'] = 'success';
				$alert['msg'] = 'Connection réussie';
				header('Location: /camagru/home');
				//Home::index();
				//include('views/header.php');
				//include('views/home_view.php');
				//include('views/footer.php');
			}
			else
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Login ou mot de passe incorrect';
				include('views/login_view.php');
			}
		}
	}

	public function check_pwd($pwd)
	{
		if (preg_match("/^(?=.*[A-Z])(?=.*[0-9]).{6,}$/", $pwd))
			return hash('whirlpool', $pwd);
		else
			return (FALSE);
	}

	public function send_confirm_email($email, $id, $key)
	{
		$to = $email;
		$subject = 'Camagru - Validez votre inscription';
		$message = '
			<html>
			<head>
			<title>Validation de votr inscription sur Camagru</title>
			</head>
			<body>
			<h1>Merci de vous être inscrit</h1>
			<p>Merci de cliquer sur le lien suivant afin de valider votre inscription</p>
			<a href="localhost:8080/camagru/validation/'.$key.'/'.$id.'">Je valide mon inscription</a>
			<p>Ou copiez ce lien dans votre navigateur:</p>
			<p>localhost:8080/camagru/validation/'.$key.'/'.$id.'">Je valide mon inscription</p>
			</body>
			</html>
			';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'From: camagru@no-reply.com' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		mail($to, $subject, $message, $headers);
	}

	public function subscribe()
	{
		global $users_model;

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
				if (!($pwd = Login::check_pwd($pwd)))
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
					if ($result = $users_model->get_user_by_login($login))
					{
						$alert['type'] = 'danger';
						$alert['msg'] = 'Le login est déjà utilisé';
						include('views/subscribe_view.php');
					}
					else
					{
						if ($result = $users_model->add_user($login, $pwd, $email, $lname, $fname))
						{
							Login::send_confirm_email($email, $result['id'], $result['key']);
							$alert['type'] = 'success';
							$alert['msg'] = 'Vous avez bien été inscrit, vérifiez votre boîte mail';
							include('views/login_view.php');
						}
						else
						{
							$alert['type'] = 'danger';
							$alert['msg'] = 'Un problème est survenu';
							include('views/subscribe_view.php');
						}
					}
				}
				else
					include('views/subscribe_view.php');

			}
		}
	}

	public function logout()
	{
		if ($_SESSION['connect'])
		{
			session_destroy();
		}
		header('Location: /camagru/login');
	}	
}
global $login;
$login = new Login;
