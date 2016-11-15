<?php
session_start();

include("config/database.php");
include("config/config.php");
if (file_exists('config/.firstime'))
	include("config/setup.php");

// inclusion de toutes les controlers
foreach (glob("controlers/*.php") as $filename)
	include_once $filename;

// check de l'url pour appeler la bonne fonction dans la bonne classe
$url = explode('/', $_SERVER[REQUEST_URI]);
if (!$url[2] || $url[2] == "index.php")
{
	$home->index();
}
else
{
	if (!class_exists($url[2]))
	{
		header("HTTP/1.1 404 Not Found");
		exit;
	}
	else
	{
		if ($url[3])
		{
			if (method_exists($url[2], $url[3]))
				call_user_func(array($url[2], $url[3]), $url[4]);
			else
			{
				header("HTTP/1.1 404 Not Found");
				exit;
			}
		}
		else
			call_user_func(array($url[2], 'index'));
	}
}
