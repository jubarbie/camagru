<div class="container">
	<div class="content">
		<img src="<?=$base_url.$image['path']?>" alt="camagru" />
		<div class="actions">
			<ul>
				<li id="del"><i class="fa fa-trash"></i></li>
				<li id="comment"></i>
			</ul>
		</div>
	</div><!--
	--><div class="side">
		<h2>Gallerie</h2>
		<div id="galery">
		<ul>
		<?php foreach($galery as $img) {
			echo '<li><a href="'.$base_url.'galery/photo/'.$img['id'].'"><img class="gal-img" src="/camagru/'.$img['path'].'" alt="'.$img['name'].'" /></li>';
		}?>
		</ul>
		</div>
	</div>
</div>
