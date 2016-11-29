<?php
Class User	
{
	public function index($alert = NULL)
	{
		global $login;
		global $users_model;
		global $base_url;
		
		if ($_SESSION['connect'] != 'yes')
		{
			header('Location: /camagru/login');
			exit;
		}
		$member = $users_model->get_user_by_login($_SESSION['login']);
		$id = $member['id'];
		$lname = $member['lname'];
		$fname = $member['fname'];
		$email = $member['email'];
		if (!$_POST['submit'])
		{	
			include ('views/header.php');
			include ('views/profile_view.php');
			include ('views/footer.php');
		}
		else
		{
			if (!$_POST['lname'] || !$_POST['fname'] || !$_POST['email'])
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Tous les champs sont requis';
				include ('views/header.php');
				include ('views/profile_view.php');
				include ('views/footer.php');
			}
			else
			{
				if (!Login::only_alphanum($_POST['lname']) ||!Login::only_alphanum($_POST['fname']))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Seuls les caractères alpanumériques sont autorisés pour le nom et le prénom';
					include ('views/header.php');
					include ('views/profile_view.php');
					include ('views/footer.php');
;
				}
				else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'L\'email n\'est pas valide';
					include ('views/header.php');
					include ('views/profile_view.php');
					include ('views/footer.php');
				}
				else
				{
					if ($users_model->update_infos($id, $_POST['email'], $_POST['lname'], $_POST['fname']))
					{
						$lname = $_POST['lname'];
						$fname = $_POST['fname'];
						$email = $_POST['email'];
						$alert['type'] = 'success';
						$alert['msg'] = 'Votre profil à bien été mis à jour';
						include ('views/header.php');
						include ('views/profile_view.php');
						include ('views/footer.php');
					}
					else
					{
						$alert['type'] = 'danger';
						$alert['msg'] = 'Un problème est survenu';
						include ('views/header.php');
						include ('views/profile_view.php');
						include ('views/footer.php');
					}
				}
			}
		}
	}
	
	public function change_pwd()
	{
		global $login;
		global $users_model;
		global $base_url;
		
		if (!$_POST['submit']) {	
			include ('views/header.php');
			include ('views/change_pwd_view.php');
			include ('views/footer.php');
		} else {
			$member = $users_model->get_user_by_id($_SESSION['id']);
			if (!$_POST['old-pwd'] || !$_POST['pwd'] || !$_POST['re-pwd'])
			{
				$alert['type'] = 'danger';
				$alert['msg'] = 'Tous les champs sont requis';
				include ('views/header.php');
				include ('views/change_pwd_view.php');
				include ('views/footer.php');
			}
			else
			{
				if (hash('whirlpool', $_POST['old-pwd']) != $member['pwd'])
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Mot de passe incorrect';
					include ('views/header.php');
					include ('views/change_pwd_view.php');
					include ('views/footer.php');
				}
				else if ($_POST['pwd'] != $_POST['re-pwd'])
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Les deux mot de passe ne sont pas identiques';
					include ('views/header.php');
					include ('views/change_pwd_view.php');
					include ('views/footer.php');
				}
				else if (!Login::check_pwd($_POST['pwd']))
				{
					$alert['type'] = 'danger';
					$alert['msg'] = 'Le mot de passe n\'est pas assez fort';
					include ('views/header.php');
					include ('views/change_pwd_view.php');
					include ('views/footer.php');
				}
				else
				{
					$pwd = hash('whirlpool', $_POST['pwd']);
					$users_model->update_pwd($_SESSION['id'], $pwd);
					$id = $member['id'];
					$lname = $member['lname'];
					$fname = $member['fname'];
					$email = $member['email'];
					$alert['type'] = 'success';
					$alert['msg'] = 'Le mot de passe à bien été mis à jour';
					include ('views/header.php');
					include ('views/profile_view.php');
					include ('views/footer.php');
				}
			}
		}
	}
}
