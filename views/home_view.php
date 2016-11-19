<div class="container">
<h1>Accueil</h1>

<div class="content">
	<div id="cam">
		<video autoplay></video>
		<button id="click"><i class="fa fa-camera" aria-hidden="true"></i></button>
	</div>

		<fieldset style="width: 640px; display: none;">
			<legend>Photo</legend>
			<img src="about:blank" alt="Photo" title="Photo" />
		</fieldset>
		<canvas style="display: none;" width="640" height="480"></canvas>
	<div>
		<h2>Dernières images</h2>
		<div id="galery">
			<ul id="gal-list">
			<?php foreach ($last as $img) {
			echo '<li><img class="gal-img" src="'.$base_url.$img['path'].'" /></li>';
			}?>		
			</ul>
		</div>
	</div>
</div><!--

--><div class="side">
	<h2>Cadres</h2>
	<ul>
	<?php foreach ($frames as $frame) {
		echo '<li><img class="frame-add" id="glasses" src="'.$base_url.'assets/img/frames/'.$frame.'" /></li>';
	}?>
	</ul>

	<h2>Stickers</h2>
	<ul>
	<?php foreach ($stickers as $sticker) {
		echo '<li><img class="img-add" id="glasses" src="'.$base_url.'assets/img/stickers/'.$sticker.'" /></li>';
	}?>
	</ul>
</div>

<script type="text/javascript">
var video = document.querySelector('video');
var canvas = document.querySelector('canvas');
var photo = document.querySelector('img');

navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
navigator.getMedia({ video: { mandatory: { maxWidth: 640, maxHeight: 480 } } }, function(stream) {
	video.src = window.URL.createObjectURL(stream);
}, function(e) {
	console.log("Failed!", e);
});

$('#click').on('click', function() {
	var ctx = canvas.getContext("2d").drawImage(video, 0, 0, 640, 480);
	var data = canvas.toDataURL('image/png');
	//alert(data);
	left = (document.getElementById('cam').offsetWidth - 640) / 2;
	var img_x = document.getElementById('glasses').style.left.slice(0, -2) - left;
	var img_y = document.getElementById('glasses').style.top.slice(0, -2);
	console.log(img_x);
	$.ajax({
		url : '/camagru/galery/add_img',
			type : 'POST',
			data : 'img=' +  data + '&x=' + img_x + '&y=' + img_y,
			success: function(data) {
				var elem = document.createElement("img");
				elem.setAttribute("src", data);
				elem.setAttribute("class", 'gal-img');
				var ul = document.getElementById("gal-list");
			 	var li = document.createElement("li");
				li.appendChild(elem);
				ul.insertBefore(li, ul.childNodes[0]);
				console.log('image added');
			},
				error: function(exception) {
					alert('Exception:'+exception);
				}
	});
	//photo.setAttribute('src', data);	
});
$('.frame-add').on('click', function() {
	var elem = document.createElement("img");
	elem.setAttribute("src", this.src);
	elem.setAttribute("width", "640");
	elem.setAttribute("alt", "Frame");
	elem.setAttribute("class", "frame-vid");
	elem.setAttribute("draggable", "false");
	elem.style.position = "absolute";
	left = (document.getElementById('cam').offsetWidth - 640) / 2;
	elem.style.left = left.toString() + 'px';
	elem.style.top = 0;
	document.getElementById("cam").appendChild(elem);
	addListeners();
});
$('.img-add').on('click', function() {
	var elem = document.createElement("img");
	elem.setAttribute("src", this.src);
	elem.setAttribute("width", "200");
	elem.setAttribute("alt", "Glasses");
	elem.setAttribute("class", "img-vid");
	elem.id = "glasses";
	elem.style.position = "absolute";
	var cam_width = document.getElementById("cam").offsetWidth; 
	var cam_height = document.getElementById("cam").offsetHeight; 
	var x_pos = ((cam_width / 2) - (elem.offsetWidth / 2)).toString() + 'px';
	var y_pos =  ((cam_height / 2) - (elem.offsetHeight / 2)).toString() + 'px';
	elem.style.left = 0;
	elem.style.top = 0;
	document.getElementById("cam").appendChild(elem);
	addListeners();
});
function addListeners() {
	document.getElementById('glasses').addEventListener('mousedown', mouseDown, false);
	window.addEventListener('mouseup', mouseUp, false);
}

function mouseUp() {
	window.removeEventListener('mousemove', divMove, true);
}

function mouseDown() {
	window.addEventListener('mousemove', divMove, true);
}

function divMove(e){
	var div = document.getElementById('glasses');
	div.style.position = 'absolute';
	div.style.top = e.clientY + 'px';
	div.style.left = e.clientX + 'px';
}
</script>
