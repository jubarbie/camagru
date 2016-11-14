<?php
function login($login, $pwd)
{
	require_once('db_connect.php');
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
		return ($result[0]);
	}
	else
		return (FALSE);
}

function add_user($login, $pwd, $email, $lname, $fname)
{
	require_once('db_connect.php');
	$sql = "INSERT INTO db_camagru.users (lname, fname, login, pwd, email) 
				VALUES (:lname, :fname, :login, :pwd, :email)";
	try {
		$query = $pdo->prepare($sql);
		$result = $query->execute(array(
								'lname' => $lname,
								'fname' => $fname,
								'login' => $login,
								'email' => $email,
								'pwd' => $pwd));
	} catch (PDOException $e) {
		echo "Problème dans la requête" . $e->getMessage();
	}
	return ($result);
}
