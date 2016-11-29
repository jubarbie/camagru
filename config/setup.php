<?php
session_destroy();
try {
	$dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
} catch (PDOException $e) {
	echo 'Connexion échouée :' . $e->getMessage();
	die();
}

$files = glob('upload/*'); // get all file names
foreach($files as $file){ // iterate files
	  if(is_file($file))
		      unlink($file); // delete file
}

$sql = '
	DROP DATABASE IF EXISTS db_camagru;
	CREATE DATABASE IF NOT EXISTS ' . $DB_NAME;
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo 'Le création de la base ' . $DB_NAME . ' à echouée: ' . $e->getMessage();
	die();
}

echo "Base de donnée créée<br />";
$sql = 'USE ' . $DB_NAME;
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo 'Impossible de rejoindre ' . $DB_NAME . ' : ' . $e->getMessage();
	die();
}

echo "Maintenant sur " . $DB_NAME . '<br />';
$sql = 'CREATE TABLE users (
			id INT PRIMARY KEY AUTO_INCREMENT,
			fname VARCHAR(255),
			lname VARCHAR(255),
			login VARCHAR(255),
			pwd VARCHAR(255),
			email VARCHAR(255),
			valid VARCHAR(255));
		CREATE TABLE images (
			id INT PRIMARY KEY AUTO_INCREMENT,
			type VARCHAR(10),
			name VARCHAR(255),
			path VARCHAR(255),
			id_user INT,
			date_ajout DATETIME);
		CREATE TABLE comments (
			id INT PRIMARY KEY AUTO_INCREMENT,
			id_img INT,
			user VARCHAR(255),
			text VARCHAR(500),
			date_ajout DATETIME);
		CREATE TABLE likes (
			id INT PRIMARY KEY AUTO_INCREMENT,
			id_img INT,
			id_user INT);';
try {
	$dbh->query($sql);
} catch (PDOException $e) {
	echo "Problème lors de la création des tables : " . $e->getMessage();
	die();
}

echo "Table users créée<br />";
$user = 'root';
$pwd = hash('whirlpool', 'root');
$email = 'jubarbie@student.42.fr';
$sql = sprintf("INSERT INTO users (fname, lname, login, email, pwd, valid)
				VALUES ('Jules', 'Barbier', '%s', '%s', '%s', 'yes')", $user, $email, $pwd);
try {
	$dbh->query($sql);
} catch(PDOException $e) {
	echo "L'ajout de l'admin à échoué : " . $e->getMessage();
	die();
}
echo "Ajout de l'administrateur dans la base: <br />Login: root<br />Mot de passe: root<br />";
echo "Redirection vers la page d'accueil<br />";
unlink('config/.firstime');
$dbh = NULL;
sleep(5);
