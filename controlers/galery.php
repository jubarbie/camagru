<?php
session_start();
Class Galery
{
	public function index()
	{
		require_once('models/galery_model.php');
		global $galery_model;

		$img_pp = 9;
		$images = $galery_model->get_all_images();
		include ('views/header.php');
		include ('views/galery_view.php');
		include ('views/footer.php');
	}

	public function page($page = 1)
	{
		require_once('models/galery_model.php');
		global $galery_model;

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
				echo $url;
			else
				echo $url;
		}
	}
}
