<?php
Class Users_model
{
	function login($login, $pwd)
	{
		require_once('config/db_connect.php');
		$sql = sprintf("SELECT * FROM db_camagru.users WHERE login = '%s'", $login);
		try {
			$query = $pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll();
		} catch (PDOException $e) {
			echo "Problème dans la requête" . $e->getMessage();
		}
		if ($result && $result[0]['pwd'] == hash('whirlpool', $pwd))
		{
			$_SESSION['connect'] = 'yes';
			$_SESSION['id'] = $result[0]['id'];
			$_SESSION['login'] = $result[0]['login'];
			$_SESSION['lname'] = $result[0]['lname'];
			$_SESSION['fname'] = $result[0]['fname'];
			$_SESSION['valid'] = $result[0]['valid'];
			return ($result[0]);
		}
		else
			return (FALSE);
	}

	function add_user($login, $pwd, $email, $lname, $fname)
	{
		require('config/db_connect.php');
		$key = uniqid();
		$sql = "INSERT INTO db_camagru.users (lname, fname, login, pwd, email, valid) 					VALUES (:lname, :fname, :login, :pwd, :email, :valid)";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'lname' => $lname,
				'fname' => $fname,
				'login' => $login,
				'email' => $email,
				'pwd' => $pwd,
				'valid' => $key));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		if ($result)
		{
			$data['key'] = $key;
			$data['id'] = $pdo->lastInsertId();
			return $data;
		}
		else
			return (FALSE);
	}

	function update_infos($id, $email, $lname, $fname)
	{
		require('config/db_connect.php');
		$key = uniqid();
		$sql = "UPDATE db_camagru.users SET lname = :lname, fname = :fname, email = :email WHERE id = :id";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'id' => $id,
				'lname' => $lname,
				'fname' => $fname,
				'email' => $email));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function get_user_by_login($login)
	{
		require_once('config/db_connect.php');
		$sql = "SELECT * FROM users WHERE login=:login";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array('login' => $login));
			$result = $query->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}	
}

global $users_model;
$users_model = new Users_model;
