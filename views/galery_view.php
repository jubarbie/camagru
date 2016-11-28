<div class="container">
<?php 
if ($nb_pages > 1) {
	for ($i = 1; $i <= $nb_pages; $i++)
	{
		if ($i == $current_page)
			echo '<span class="page-num page-num-current">'.$i.'</span>';
		else
			echo '<a class="page-num" href="/camagru/galery/page/'.$i.'">'.$i.'</a>';
	}}
?>
</div>

<div class="container">
<div id="galery">
<?php
if ($images)
{
	
	echo '<ul style="width: 100%;"><!--';
	foreach ($images as $image)
	{
		echo '--><li><a href="'.$base_url.'galery/photo/'.$image['id'].'">';
		echo '<img class="gal-img" src="/camagru/'.$image['path'].'" alt="'.$image['name'].'" />';
		echo '</a></li><!--';
	}
	echo '--></ul>';	
}
else
	echo '<p>Pas d\'images dans la gallerie. <a href="/camagru">Créer une nouvelle image</a></p>';
?>
</div>
</div>

<div class="container">
<?php 
if ($nb_pages > 1) {
	for ($i = 1; $i <= $nb_pages; $i++)
	{
		if ($i == $current_page)
			echo '<span class="page-num page-num-current">'.$i.'</span>';
		else
			echo '<a class="page-num" href="/camagru/galery/page/'.$i.'">'.$i.'</a>';
	}}
?>
</div>

