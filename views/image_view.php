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
			<button id="add-comment" onclick="add_comment('<?=$image['id']?>', '<?=$_SESSION['login']?>')">Ajouter</button>
		</div>
		<?php }?>

		<div id="comments">
		<?php foreach ($comments as $comment) {
			echo '<div class="comment">';
			echo "<div class='comment-info'>Le ".date_format(date_create($comment['date_ajout']), "d/m/Y à H\hi");
			echo ' par '.$comment['user'].'</div>';
			echo '<p>'.$comment['text'].'</p>';
			echo '</div>';
		}?>
		</div>
	</div><!--
	--><div class="side side-right">
	<div><div id="likes"><div id="likes-num"><?=$likes?></div><div class="btn btn-blue" onclick="add_like(<?=$image['id']?>)"><i class="fa fa-thumbs-up"></i></div></div></div>
		<?=($_SESSION['id'] == $image['id_user']) ? '<div class="btn btn-red" onclick="delete_img('.$_SESSION['id'].', '.$image['id'].')"><i class="fa fa-trash"></i></div>' : '';?>
	</div>
</div>

	<script>
	function add_comment(id_img, usr) {
		var comment = document.getElementById('new-comment').value;
		if (comment != '')
		{
		xhr = new XMLHttpRequest();
		xhr.open('POST', '/camagru/galery/add_comment');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200) {
				var com = JSON.parse(xhr.responseText);
				var c_infos = document.createElement("div");
				var c_text = document.createElement("p");
				var comment = document.createElement("div");
				var comments = document.getElementById("comments");
				var date = new Date(com.date_ajout);
				var day = date.getDate();
				var month = date.getMonth() + 1;
				var year = date.getFullYear();
				var hour = date.getHours();
				var min = date.getMinutes();
				c_infos.setAttribute('class', "comment-info");
				comment.setAttribute('class', "comment");
				c_infos.innerHTML = "Le " + day + "/" + month + "/" + year + " à " + hour + "h" + min + " par " + com.user;
				c_text.innerHTML = com.text;
				comment.appendChild(c_infos);
				comment.appendChild(c_text);
				comments.insertBefore(comment, comments.firstChild);
				console.log('comment added: ' + xhr.responseText);
				document.getElementById('new-comment').value = '';
			}
			else if (xhr.status !== 200) {
				alert('Request failed.  Returned status of ' + xhr.status);
			}
		};
		xhr.send(encodeURI('img=' + id_img + '&usr=' + usr + '&comment=' + comment));
		}
	};
	function delete_img(id_usr, id_img) {
		if (confirm("Es-tu sûr de vouloir supprimer cette image?"))
		{
			xhr = new XMLHttpRequest();
			xhr.open('POST', '/camagru/galery/delete_image');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					document.location.href="/camagru/galery/page";
				}
				else if (xhr.status !== 200) {
					alert('Request failed.  Returned status of ' + xhr.status);
				}
			};
			xhr.send(encodeURI('img=' + id_img));
		}
	};
	function add_like(id_img) {
			xhr = new XMLHttpRequest();
			xhr.open('POST', '/camagru/galery/like_img');
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if (xhr.status === 200) {
					document.getElementById("likes-num").innerHTML = xhr.responseText;
				}
				else if (xhr.status !== 200) {
					alert('Request failed.  Returned status of ' + xhr.status);
				}
			};
			xhr.send(encodeURI('img=' + id_img));
	};
	</script>
