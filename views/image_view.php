<div class="container">
	<div class="side side-left">
		<div id="side-galery">
		<ul>
<?php foreach($galery as $img) {
	echo '<li><a href="'.$base_url.'galery/photo/'.$img['id'].'"><img class="gal-img" src="/camagru/'.$img['path'].'" alt="'.$img['name'].'" /></a></li>';
}?>
		</ul>
		</div>
	</div><!--
	--><div class="content">
		<img class="img-border" src="<?=$base_url.$image['path']?>" alt="camagru" />
		
		<? if ($_SESSION['valid'] == 'yes') {?>
		<div id="btn-cam" style="margin-top: -10px;">
			<label for="new-comment">Commentaire</label>
			<textarea id="new-comment" name="comment-text"></textarea>
			<button id="add-comment" onclick="add_comment(<?=$image['id']?>, <?=$_SESSION['id']?>)">Ajouter</button>
		</div>
		<?php }?>
	</div><!--
	--><div class="side side-right">
		<?=($_SESSION['id'] == $image['id_user']) ? '<li id="del-btn" onclick="delete_img('.$_SESSION['id'].', '.$image['id'].')"><i class="fa fa-trash"></i></li>' : '';?>
		<div id="comments">
		<?php foreach ($comments as $comment) {
			echo '<p>'.$comment['text'].'</p>';
		}?>
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
