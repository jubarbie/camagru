<?php
if ($_SESSION['connect'])
{
	session_destroy();
	include ('controlers/login.php');
}
