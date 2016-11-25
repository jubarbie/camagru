<?php
Class Comments_model
{
	function add_comment($id_img, $id_user, $comment)
	{
		require('config/db_connect.php');
		$sql = "INSERT INTO comments (id_img, id_user, text, date_ajout) 							VALUES (:id_img, :id_user, :comment, NOW())";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array(
				'id_img' => $id_img,
				'id_user' => $id_user,
				'comment' => $comment));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function delete_comment($id)
	{
		require('config/db_connect.php');
		$sql = "DELETE FROM comments WHERE id=:id";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array('id' => $id));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}

	function delete_all_comments_from_img($id_img)
	{
		require('config/db_connect.php');
		$sql = "DELETE FROM comments WHERE id_img=:id_img";
		try {
			$query = $pdo->prepare($sql);
			$result = $query->execute(array('id_img' => $id_img));
		} catch (PDOException $e) {
			echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}


	function get_image_comments($id_img)
	{
		require('config/db_connect.php');
		$sql = "SELECT * FROM comments WHERE id_img=:id_img";
		try {
			$query = $pdo->prepare($sql);
			$query->execute(array('id_img' => $id_img));
			$result = $query->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
				echo "Problème dans la requête: " . $e->getMessage();
		}
		return ($result);
	}
}

global $comments_model;
$comments_model = new Comments_model;
