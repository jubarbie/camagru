<div class="container">
<div id="galery">
<h1>Gallerie</h1>
<?php
if ($images)
{
	echo '<ul>';
	foreach ($images as $image)
	{
		echo '<li>';
		echo '<img class="gal-img" src="/camagru/'.$image['path'].'" alt="'.$image['name'].'" />';
		echo '</li>';
	}
	echo '</ul>';
	echo '<p>Page : </p>';
	for ($i = 1; $i <= $nb_pages; $i++)
	{
		if ($i == $current_page)
			echo '['.$i.']';
		else
			echo '<a href="/camagru/galery/page/'.$i.'">'.$i.'</a>';
	}
}
else
	echo '<p>Pas d\'images dans la gallerie. <a href="/camagru">Créer une nouvelle image</a></p>';
?>
</div>
</div>
