<?php
session_start();
Class User	
{
	public function index($alert = NULL)
	{
		global $login;
		global $users_model;
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
				if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
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
}
