<?php
session_start();
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
		$img_pp = 9;
		$images = $galery_model->get_all_images();
		include ('views/header.php');
		include ('views/galery_view.php');
		include ('views/footer.php');
	}

	public function photo($id = NULL)
	{
		require_once('models/galery_model.php');
		global $galery_model;
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
			$galery = $galery_model->get_all_images();
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
		$img_pp = 9;
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
			if ($galery_model->add_image($name, 'png', $url, $_SESSION['id']))
			{
				$src = imagecreatefrompng('assets/img/stickers/glasses.png');
				$dst = imagecreatefrompng($url);
				
				$src_width = imagesx($src);
				$src_height = imagesy($src);
				$dst_width = imagesx($dst);
				$dst_height = imagesy($dst);

				$dst_x = $dst_width - $src_width;
				$dst_y =  $dst_height - $src_height;

				// On met le logo (source) dans l'image de destination (la photo)
				imagecopy($dst, $src, $_POST['x'], $_POST['y'], 0, 0, $src_width, $src_height);

				// On affiche l'image de destination qui a été fusionnée avec le logo
				imagepng($dst, $url);
				echo $base_url.$url;
			}
			else
				echo FALSE;
		}
	}

	public function add_comment()
	{
		require_once('models/galery_model.php');
		global $galery_model;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}

	}
}
