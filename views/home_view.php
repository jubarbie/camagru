<div class="container">
<h1>Accueil</h1>

<div id="cam" style="position: relative"><video autoplay></video></div>
<button id="click"><i class="fa fa-camera" aria-hidden="true"></i></button>

<fieldset style="width: 640px; display: inline-block;">
	  <legend>Photo</legend>
	  <img src="about:blank" alt="Photo" title="Photo" />
	</fieldset>

	<canvas style="display: none;" width="640" height="480"></canvas>
	<div>
		<ul>
			<li><img class="img-add" src="assets/img/glasses.png" /></li>
		</ul>
	</div>
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
	$.ajax({
		url : '/camagru/galery/add_img',
			type : 'POST',
			data : 'img=' +  data + '&x=10&y=10',
			success: function(data) {
				photo.setAttribute('src', data);
				console.log('success', data);
			},
				error: function(exception) {
					alert('Exception:'+exception);
				}
	});
	//photo.setAttribute('src', data);	
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
	elem.style.left = x_pos;
	elem.style.top = y_pos;
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
