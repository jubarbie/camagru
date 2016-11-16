<div class="container">
<h1>Accueil</h1>

<video autoplay></video>
<button id="click"><i class="fa fa-camera" aria-hidden="true"></i></button>

<fieldset style="width: 640px; display: inline-block;">
      <legend>Photo</legend>
      <img src="about:blank" alt="Photo" title="Photo" />
    </fieldset>

    <canvas style="display: none;" width="640" height="480"></canvas>

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
		data : 'img=' +  data,
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
</script>
