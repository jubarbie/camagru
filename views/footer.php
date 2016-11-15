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

function takephoto() {
	var ctx = canvas.getContext("2d").drawImage(video, 0, 0, 640, 480);
	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
}
</script>
</body>
</html>
