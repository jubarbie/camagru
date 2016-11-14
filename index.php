<?php
session_start();

include("config.php");
if (file_exists('.firstime'))
	include("install.php");


$url = explode('/', $_SERVER[REQUEST_URI]);
if (!$url[2] || $url[2] == "index.php")
	include("controlers/home.php");
else
{
	$file = "controlers/" . $url[2] . ".php";
	if (!file_exists($file))
	{
		header("HTTP/1.1 404 Not Found");
		exit;
	}
	else
		include ($file);
}
/*
else if (!$_SESSION['connect'])
{
	include("controlers/login.php");
}
else
{
	$url = explode('/', $_SERVER[REQUEST_URI]);
	if (!$url[2] || $url[2] == "index.php")
		include("controlers/home.php");
	else
	{
		$file = "controlers/" . $url[2] . ".php";
		if (!file_exists($file))
		{
			header("HTTP/1.1 404 Not Found");
			exit;
		}
		else
			include ($file);
	}
}*/
