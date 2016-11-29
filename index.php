<?php
session_start();
global $base_url;
$base_url = '/'.basename(__DIR__).'/';
include("config/database.php");
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
		header("HTTP/1.0 404 Not Found");
		require ('views/404_view.php');
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
				header("HTTP/1.0 404 Not Found");
				require ('views/404_view.php');
				exit;
			}
		}
		else
			call_user_func(array($url[2], 'index'));
	}
}
