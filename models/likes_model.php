<?php
Class Likes_model
{
	function add_like($id_img, $id_user)
	{
		require('config/db_connect.php');
		$sql = "INSERT INTO likes (id_img, id_user)
				VALUES (:id_img, :id_user)";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'id_img' => $id_img,
				'id_user' => $id_user));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($pdo->lastInsertId());
	}

	function remove_like($id_img, $id_user)
	{
		require('config/db_connect.php');
		$sql = "DELETE FROM likes WHERE id_img=:id_img AND id_user=:id_user";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'id_img' => $id_img,
				'id_user' => $id_user));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function get_img_likes($id_img)
	{
		require('config/db_connect.php');
		$sql = "SELECT COUNT(*) AS likes FROM likes WHERE id_img = :id_img";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array('id_img' => $id_img));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result[0]['likes']);
	}
	
	function is_liked($id_user, $id_img)
	{
		require('config/db_connect.php');
		$sql = "SELECT COUNT(*) AS 'num_likes' FROM likes WHERE id_img = :id_img AND id_user = :id_user";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array(
				'id_img' => $id_img,
				'id_user' => $id_user));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result[0]['num_likes']);
	}
}

global $likes_model;
$likes_model = new Likes_model;
