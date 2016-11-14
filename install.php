<?php

try {
	$dbh = new PDO('mysql:host='.$config['db_host'], $config['db_user'], $config['db_pwd']);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée :' . $e->getMessage();
	die();
}

$sql = 'CREATE DATABASE ' . $config['db_name'];
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo 'Le création de la base ' . $config['db_name'] . ' à echouée<br />';
	die();
}

echo "Base de donnée créée<br />";
$sql = 'USE ' . $config['db_name'];
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo 'Impossible de rejoindre ' . $config['db_name'] . ' : ' . $e->getMessage();
	die();
}

echo "Maintenant sur " . $config['db_name'] . '<br />';
$sql = 'CREATE TABLE users (
			id INT PRIMARY KEY AUTO_INCREMENT,
			fname VARCHAR(255),
			lname VARCHAR(255),
			login VARCHAR(255),
			pwd VARCHAR(255),
			email VARCHAR(255))';
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo "Problème lors de la création de la table users : " . $e->getMessage();
	die();
}

echo "Table users créée<br />";
$user = 'root';
$pwd = hash('whirlpool', 'root');
$sql = sprintf("INSERT INTO users (fname, lname, login, pwd)
				VALUES ('Jules', 'Barbier', '%s', '%s')", $user, $pwd);
echo $sql;
try {
	$dbh->query($sql);
} catch(PDOException $e) {
	echo "L'ajout de l'admin à échoué : " . $e->getMessage();
	die();
}
echo "Ajout de l'administrateur dans la base: <br />Login: root<br />Mot de passe: root<br />";
echo "Redirection vers la page d'accueil dans 5 sec...<br />";
unlink('.firstime');
$dbh = NULL;
sleep(5);
