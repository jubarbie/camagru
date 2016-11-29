<?php
Class Galery
{
	public function index()
	{
		require_once('models/galery_model.php');
		global $galery_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		$img_pp = 12;
		$images = $galery_model->get_all_images();
		include ('views/header.php');
		include ('views/galery_view.php');
		include ('views/footer.php');
	}

	public function photo($id = NULL)
	{
		require_once('models/galery_model.php');
		require_once('models/comments_model.php');
		require_once('models/likes_model.php');
		global $galery_model;
		global $likes_model;
		global $comments_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		if ($id == NULL || !($image = $galery_model->get_image($id)))
			Galery::index();
		else
		{
			$image = $image[0];
			$likes = $likes_model->get_img_likes($id);
			$liked = $likes_model->is_liked($_SESSION['id'], $id);
			$galery = $galery_model->get_all_images();
			$comments = $comments_model->get_image_comments($id);
			include ('views/header.php');
			include ('views/image_view.php');
			include ('views/footer.php');
		}
	}

	public function page($page = 1)
	{
		require_once('models/galery_model.php');
		global $galery_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		$img_pp = 12;
		$total = $galery_model->get_num_images();
		$nb_pages = ceil($total/$img_pp);
		if (isset($page))
		{
			$current_page = intval($page);
			if ($current_page > $nb_pages)
				$current_page = $nb_pages;
		}
		else
			$current_page = 1;
		$first = ($current_page - 1) * $img_pp;
		$images = $galery_model->get_images_pag($first, $img_pp);
		include ('views/header.php');
		include ('views/galery_view.php');
		include ('views/footer.php');
	}
	
	private function merge_images($url_dst, $url_src, $x, $y)
	{
		$src = imagecreatefrompng($url_src);
		$dst = imagecreatefrompng($url_dst);
				
		$src_width = imagesx($src);
		$src_height = imagesy($src);
		$dst_width = imagesx($dst);
		$dst_height = imagesy($dst);

		$dst_x = $dst_width - $src_width;
		$dst_y =  $dst_height - $src_height;

		// On met le logo (source) dans l'image de destination (la photo)
		imagecopy($dst, $src, $x, $y, 0, 0, $src_width, $src_height);

		// On affiche l'image de destination qui a été fusionnée avec le logo
		imagepng($dst, $url_dst);
	}

	public function add_img()
	{
		require_once('models/galery_model.php');
		global $galery_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		$img = $_POST['img'];
		$name = uniqid();
		$url = 'upload/'.$name.'.png';
		if ($img)
		{
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			file_put_contents($url, $data);
			if ($id = $galery_model->add_image($name, 'png', $url, $_SESSION['id']))
			{
				if ($_POST['stk'] != 'null')
				{
					$url_src = 'assets/img/stickers/'.$_POST['stk'];
					Galery::merge_images($url, $url_src, $_POST['stkx'], $_POST['stky']);
				}
				if ($_POST['fr'] != 'null')
				{
					$url_src = 'assets/img/frames/'.$_POST['fr'];
					Galery::merge_images($url, $url_src, 0, 0);
				}
				echo '<a href="'.$base_url.'galery/photo/'.$id.'"><img class="gal-img" src="'.$base_url.$url.'" /></a>';
				//echo $base_url.$url;
			}
			else
				echo FALSE;
		}
	}

	public function like_img()
	{
		require_once('models/galery_model.php');
		require_once('models/likes_model.php');
		global $galery_model;
		global $likes_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		if ($_POST['img'] && $_SESSION['id'])
		{
			if ($img = $galery_model->get_image($_POST['img']))
			{
				if (($like = $likes_model->is_liked($_SESSION['id'], $_POST['img'])))
					$likes_model->remove_like($_POST['img'], $_SESSION['id']);
				else
					$likes_model->add_like($_POST['img'], $_SESSION['id']);
			}
		}
		echo $likes_model->get_img_likes($_POST['img']);
	}
	
	public function add_comment()
	{
		require_once('models/comments_model.php');
		require_once('models/galery_model.php');
		require_once('models/users_model.php');
		global $comments_model;
		global $galery_model;
		global $users_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		if (($text = $_POST['comment']))
		{
			$id = $comments_model->add_comment($_POST['img'], $_POST['usr'], $text);
			$img = $galery_model->get_image($_POST['img']);
			$usr = $users_model->get_user_by_id($img['id_user']);
			mail($usr['email'], "Camagru - commentaire", "Une de vos photo vient d'être commentée par un de nos utilisateur");
			$comment = $comments_model->get_comment($id);
			echo json_encode($comment[0]);
		}
		else
			echo 'FALSE';
	}

	public function delete_image()
	{
		require_once('models/galery_model.php');
		require_once('models/comments_model.php');
		global $comments_model;
		global $galery_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		if ($_POST['usr'] == $_SESSION['id'] && $_POST['img'])
		{
			$galery_model->delete_image($_POST['img']);
			$comments_model->delete_all_comments_from_img($_POST['img']);
			echo "OK";
		}
		else
			echo 'FALSE';
	}
}
