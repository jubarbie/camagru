<?php
session_start();
Class Home 
{
	public function index()
	{
		require_once('models/galery_model.php');
		global $galery_model;
		global $base_url;
		
		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		include ('views/header.php');
		if ($_SESSION['valid'] == 'yes')
		{
			$stickers = scandir('assets/img/stickers');
			unset($stickers[1]);
			unset($stickers[0]);
			$frames = scandir($URL.'assets/img/frames');
			unset($frames[0]);
			unset($frames[1]);
			$last = $galery_model->get_images_from_user($_SESSION['id'], 10);
			include ('views/home_view.php');
		}
		else
			include('views/home_not_valid_view.php');
		include ('views/footer.php');
	}
}

global $home;
$home = new Home;
