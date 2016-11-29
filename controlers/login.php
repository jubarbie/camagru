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
		global $base_url;

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
				header('Location: '.$base_url.'home');
			}
			else
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Login ou mot de passe incorrect';
				include('views/login_view.php');
			}
		}
	}
	
	public function reset_pwd() 
	{
		global $users_model;
		global $base_url;

		if (!$_POST['submit'] || !$_POST['login'])
			include('views/reset_pwd_view.php');
		else
		{
			$login = $_POST['login'];
			$user = $users_model->get_user_by_login($login);
			if ($user['login'] == $login)
			{
				$pwd = uniqid();
				$users_model->update_pwd($user['id'], hash('whirlpool', $pwd));
				$msg = "Voici votre nouveau mot de passe: " . $pwd;
				mail($user['email'], "Camagru - Réinitialisation du mot de passe", $msg);
				$alert['type'] = 'success';
				$alert['msg'] = 'Nous t\'avons envoyé un email';
				include('views/login_view.php');
			}
			else
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Login incorrect';
				include('views/reset_pwd_view.php');
			}
		}
	}

	public function check_pwd($pwd)
	{
		if (preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/", $pwd))
			return hash('whirlpool', $pwd);
		else
			return (FALSE);
	}

	public function only_alphanum($str)
	{
		if (preg_match("/^\w+$/", $str))
			return (TRUE);
		else
			return (FALSE);
	}

	public function send_confirm_email($email, $id, $key)
	{
		global $base_url;
		
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
			<p>localhost:8080'.$base_url.'login/validation/?key='.$key.'&id='.$id.'</p>
			</body>
			</html>
			';

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'From: camagru@no-reply.com' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		mail($to, $subject, $message, $headers);
	}

	public function validation()
	{
		global $users_model;
		
		if (isset($_GET['key']) && isset($_GET['id']))
		{
			if ($user = $users_model->get_user_by_id($_GET['id']))
			{
				if ($user['valid'] != 'yes' && $user['valid'] == $_GET['key'])
				{
					$users_model->valid_user($_GET['id']);
					Login::index();
				}
				else
				{
					header("HTTP/1.0 404 Not Found");
					exit();
				}
			}
			else
			{
				header("HTTP/1.0 404 Not Found");
				exit();
			}
		}
		else
		{
			header("HTTP/1.0 404 Not Found");
			exit();
		}
	}

	public function subscribe()
	{
		global $users_model;
		global $base_url;

		if (!$_POST['submit'])
			include('views/subscribe_view.php');
		else
		{
			$login = $_POST['login'];
			$pwd = $_POST['pwd'];
			$repwd = $_POST['re-pwd'];
			$lname = $_POST['lname'];
			$fname = $_POST['fname'];
			$email = $_POST['email'];
			if (!$login || !$pwd || !$lname || !$fname || !$email || !$repwd)
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Tous les champs sont requis';
				include('views/subscribe_view.php');
			}
			else
			{
				if (!Login::only_alphanum($login) || !Login::only_alphanum($lname) ||!Login::only_alphanum($fname))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Seuls les caractères alpanumériques sont autorisés pour le login, le nom et le prénom';
					include('views/subscribe_view.php');
				}
				else if ($result = $users_model->get_user_by_login($login))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Le login est déjà utilisé';
					include('views/subscribe_view.php');
				}
				else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'L\'email n\'est pas valide';
					include('views/subscribe_view.php');
				} 
				else if (!($h_pwd = Login::check_pwd($pwd)))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Le mot de passe n\'est pas assez fort<br>6 caractères alphanumériques min.<br>Au moins une lettre capitale<br>Au moins un chiffre';
					include('views/subscribe_view.php');
				}
				else if ($pwd != $repwd)
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Les deux mots de passe ne sont pas identiques';
					include('views/subscribe_view.php');
				}					
				else if ($result = $users_model->add_user($login, $h_pwd, $email, $lname, $fname))
				{
					Login::send_confirm_email($email, $result['id'], $result['key']);
					$alert['type'] = 'success';
					$alert['msg'] = 'Tu es inscrit, vérifie ta boîte mail';
					include('views/login_view.php');
				}
				else
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Un problème est survenu nors de la requête';
					include('views/subscribe_view.php');
				}
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
