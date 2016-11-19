<?php
Class Galery_model
{
	function add_image($name, $type, $path, $user_id)
	{
		require('config/db_connect.php');
		$sql = "INSERT INTO images (name, type, path, id_user, date_ajout) 							VALUES (:name, :type, :path, :id_user, NOW())";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'type' => $type,
				'name' => $name,
				'path' => $path,
				'id_user' => $user_id));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function delete_image($id)
	{
		require('config/db_connect.php');
		$sql = "DELETE FROM images WHERE id=:id";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array('id' => $id));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function get_image($id)
	{
		require('config/db_connect.php');
		$sql = "SELECT * FROM images WHERE id=:id";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array('id' => $id));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function get_num_images()
	{
		require('config/db_connect.php');
		$sql = "SELECT COUNT(*) as total FROM images";
		try
		{
			$query = $pdo->prepare($sql);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result['total']);

	}

	function get_all_images()
	{
		require('config/db_connect.php');
		$sql = "SELECT * FROM images";
		try {
			$query = $pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function get_images_from_user($id_user, $limit = NULL)
	{
		require('config/db_connect.php');
		$sql = "SELECT * FROM images WHERE id_user = :id_user ORDER BY date_ajout DESC LIMIT 10 ";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array('id_user' => $id_user));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	
	function get_images_pag($first, $offset)
	{
		require('config/db_connect.php');
		$sql = "SELECT * FROM images ORDER BY date_ajout DESC LIMIT ".$first.",".$offset.";";
		try {
			$query = $pdo->prepare($sql);
			$query->execute();
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}
}

global $galery_model;
$galery_model = new Galery_model;
