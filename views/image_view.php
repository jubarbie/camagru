<div class="container">
	<div class="content">
		<img src="<?=$base_url.$image['path']?>" alt="camagru" />
		<div class="actions">
			<ul>
				<?=($_SESSION['id'] == $image['id_user']) ? '<li id="del-btn" onclick="delete_img('.$_SESSION['id'].', '.$image['id'].')"><i class="fa fa-trash"></i></li>' : '';?>
				<li id="comment-btn"><i class="fa fa-comments"></i></i>
			</ul>
		</div>
		<div id="new-com">
			<label for="new-comment">Commentaire</label>
			<textarea id="new-comment" name="comment-text"></textarea>
			<button id="add-comment" onclick="add_comment(<?=$image['id']?>, <?=$_SESSION['id']?>)">Ajouter</button>
		</div>
		<div id="comments">
			<?php foreach ($comments as $comment) {
				echo '<p>'.$comment['text'].'</p>';
			}?>
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

	<script>
	function add_comment(id_img, id_usr) {
		var comment = document.getElementById('new-comment').value;
		xhr = new XMLHttpRequest();
		xhr.open('POST', '/camagru/galery/add_comment');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200) {
				console.log('comment added: ' + xhr.responseText);
			}
			else if (xhr.status !== 200) {
				alert('Request failed.  Returned status of ' + xhr.status);
			}
		};
		xhr.send(encodeURI('img=' + id_img + '&usr=' + id_usr + '&comment=' + comment));
	};
	function delete_img(id_usr, id_img) {
		xhr = new XMLHttpRequest();
		xhr.open('POST', '/camagru/galery/delete_image');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200) {
				document.location.href="/camagru/galery/page"
			}
			else if (xhr.status !== 200) {
				alert('Request failed.  Returned status of ' + xhr.status);
			}
		};
		xhr.send(encodeURI('img=' + id_img + '&usr=' + id_usr));
	};
	</script>
