<?php
if (!$_SESSION['connect'])
	include('controlers/login.php');
else
{
	include ('views/header.php');
	include ('views/home_view.php');
	include ('views/footer.php');
}
