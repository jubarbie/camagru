<?php
session_start();
Class Home 
{
	public function index()
	{
		global $login;
		
		if (!$_SESSION['connect'])
			$login->index();
		else
		{
			include ('views/header.php');
			if ($_SESSION['valid'] == 'yes')
				include ('views/home_view.php');
			else
				include('views/home_not_valid_view.php');
			include ('views/footer.php');
		}
	}
}

global $home;
$home = new Home;
