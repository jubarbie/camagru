<?php
include ('config/database.php');
try {
	$pdo = new PDO($DB_DSN.';dbname='.$DB_NAME, $DB_USER, $DB_PASSWORD, $DB_OPTION);
} catch (PDOException $e) {
	echo 'Connexion échouée :' . $e->getMessage();
	die();
}
