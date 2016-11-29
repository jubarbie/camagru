<div class="container">
	<div class="side side-left gr-bg">
		<ul id="list-stickers">
			<?php foreach ($stickers as $sticker) {
				echo '<li><img class="img-add" draggable="false" onclick="add_sticker(this)" src="'.$base_url.'assets/img/stickers/'.$sticker.'" /></li>';
			}?>
		</ul>
	</div><!--
	--><div class="content">
		<div id="cam">
			<video autoplay style="height: 480px; background: black; width: 640px;"></video>
			<div id="load-img" class="align-center">
				<p class="align-center">La vidéo semble désactivée. Tu peux télécharger une image</p>
				<input type="file" onchange="previewFile()" accept="image/*" />
			</div>
			<img id="prev-img" src="" width="640" height="480" alt="Image preview..." draggable="false">
			<canvas style="display: none;" width="640" height="480"></canvas>
		</div>
		<div class="align-center" id="btn-cam" style="position: relative; z-index: 10000">
			<button id="take-photo" onclick="take_picture()"><i class="fa fa-camera" aria-hidden="true"></i></button>
			<button id="clear" onclick="remove_images()"><i class="fa fa-close" aria-hidden="true"></i></button>
		</div>
	</div><!--
	--><div class="side side-right gr-bg">
		<ul>
			<?php foreach ($frames as $frame) {
			echo '<li><img class="frame-add" onclick="add_frame(this)" src="'.$base_url.'assets/img/frames/'.$frame.'" /></li>';
			}?>
		</ul>
	</div><!-- .side-right -->
</div><!-- .container -->

<div class="gr-bg">
	<div class="container">
		<div class="content">
			<div id="galery">
				<ul id="gal-list"><!--
<?php foreach ($last as $img) {
	echo '--><li><a href="'.$base_url.'galery/photo/'.$img['id'].'"><img class="gal-img" src="'.$base_url.$img['path'].'" /></a></li><!--';
}?>		
				--></ul>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var video = document.querySelector('video');
	var canvas = document.querySelector('canvas');
	var img = document.getElementById('prev-img');
	var vid_on = 'yes';

	navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
	navigator.getMedia({ video: { mandatory: { maxWidth: 640, maxHeight: 480 } } }, function(stream) {
		video.src = window.URL.createObjectURL(stream);
	}, function(e) {
		console.log("Video Failed!", e);
		document.getElementById('load-img').style.display = "inherit";
		vid_on = 'no';
		document.getElementById('take-photo').style.display = "none";
	});

	function previewFile(){
		var preview = document.getElementById('prev-img'); //selects the query named img
		var file    = document.querySelector('input[type=file]').files[0]; //sames as here
		var reader  = new FileReader();

		reader.onloadend = function () {
			preview.src = reader.result;
		}

		if (file) {
			reader.readAsDataURL(file); //reads the data as a URL
			document.getElementById('prev-img').style.display = "inherit";
			document.getElementById('take-photo').style.display = "inline";
		} else {
			preview.src = "";
		}
	}
	function remove_images() {
		var fr = document.getElementById("frame-vid");
		var stk = document.getElementById("img-vid");
		if (fr)
		{
			fr.outerHTML = "";
			delete fr;
		}
		if (stk)
		{
			stk.outerHTML = "";
			delete stk;
		}
		document.getElementById('prev-img').style.display = "none";
		document.getElementById('prev-img').setAttribute('src', "");
		if (vid_on == 'false')
			document.getElementById('take-photo').style.display = "none";
	};

	function take_picture() {
		if (vid_on == 'yes')
		{
			var ctx = canvas.getContext("2d").drawImage(video, 0, 0, 640, 480);
			var data = canvas.toDataURL('image/png');
		} else {
			var ctx = canvas.getContext("2d").drawImage(img, 0, 0, 640, 480);
			var data = canvas.toDataURL('image/png'); 
		}
		var left = (document.getElementById('cam').offsetWidth - 640) / 2;
		var sticker = document.getElementById('img-vid');
		if (sticker) {
			sticker = sticker.getAttribute('src');
			sticker = sticker.substr(sticker.lastIndexOf('/') + 1);
			var sticker_x = document.getElementById('img-vid').style.left.slice(0, -2) - left;
			var sticker_y = document.getElementById('img-vid').style.top.slice(0, -2);
		}
		var frame = document.getElementById('frame-vid');
		if (frame) {
			frame = frame.getAttribute('src');
			frame = frame.substr(frame.lastIndexOf('/') + 1);
			var frame_x = document.getElementById('frame-vid').style.left.slice(0, -2) - left;
			var frame_y = document.getElementById('frame-vid').style.top.slice(0, -2);
		}
		xhr = new XMLHttpRequest();
		xhr.open('POST', '/camagru/galery/add_img');
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			if (xhr.status === 200) {
				var ul = document.getElementById("gal-list");
				var li = document.createElement("li");
				li.innerHTML = xhr.responseText;
				ul.insertBefore(li, ul.childNodes[0]);
				console.log('image added' + xhr.responseText);
				while (ul.children.length > 8)
				{
					ul.lastChild.remove();
				}
			}
			else if (xhr.status !== 200) {
				alert('Request failed.  Returned status of ' + xhr.status);
			}
		};
		console.log('sticker: ' + sticker);	
		console.log('frame: ' + frame);
		xhr.send(encodeURI('img=' + data + '&stk=' + sticker + '&stkx=' + sticker_x + '&stky=' + sticker_y + '&fr=' + frame));
	};

	function add_frame(frame) {
		if (vid_on == 'yes' || (vid_on == 'no' && img.style.display == 'inherit'))
		{
		var elem = document.createElement("img");
		var fr = document.getElementById("frame-vid");
		if (fr)
		{
			fr.outerHTML = "";
			delete fr;
		}
		elem.setAttribute("src", frame.src);
		elem.setAttribute("width", "640");
		elem.setAttribute("alt", "Frame");
		elem.id = "frame-vid";
		elem.setAttribute("draggable", "false");
		elem.style.position = "absolute";
		left = (document.getElementById('cam').offsetWidth - 640) / 2;
		elem.style.left = left.toString() + 'px';
		elem.style.top = 0;
		document.getElementById("cam").appendChild(elem);
		}
	};
	function add_sticker(stick) {
		if (vid_on == 'yes' || (vid_on == 'no' && img.style.display == 'inherit'))
		{
		var elem = document.createElement("img");
		var fr = document.getElementById("img-vid");
		if (fr)
		{
			fr.outerHTML = "";
			delete fr;
		}
		elem.setAttribute("src", stick.src);
		elem.setAttribute("alt", "Sticker");
		elem.setAttribute("draggable", "false");
		elem.id = "img-vid";
		elem.style.position = "absolute";
		var cam_width = document.getElementById("cam").offsetWidth; 
		var cam_height = document.getElementById("cam").offsetHeight; 
		var x_pos = ((cam_width / 2) - (elem.offsetWidth / 2)).toString() + 'px';
		var y_pos =  ((cam_height / 2) - (elem.offsetHeight / 2)).toString() + 'px';
		elem.style.left = 0;
		elem.style.top = 0;
		document.getElementById("cam").appendChild(elem);
		var fr = document.getElementById("frame-vid");
		if (fr) add_frame(fr);
		addListeners(elem);
		//document.getElementById("take-photo").style.zIndex = elem.style.zIndex + 10;
		}
	};
	function addListeners(elem) {
		elem.addEventListener('mousedown', mouseDown, false);
		window.addEventListener('mouseup', mouseUp, false);
	}

	function mouseUp() {
		window.removeEventListener('mousemove', divMove, true);
	}

	function mouseDown() {
		window.addEventListener('mousemove', divMove, true);
	}

	function divMove(e){
		var div = document.getElementById('img-vid');
		var left = document.getElementById('cam').offsetLeft - document.getElementById('cam').style.width;
		var top = document.getElementById('cam').offsetTop - document.getElementById('img-vid').style.height;
		div.style.position = 'absolute';
		div.style.top = e.clientY - top + 'px';
		div.style.left = e.clientX - left + 'px';
	}
	</script>
