<div class="container">
<h1>Accueil</h1>

<p>Bienvenue <?=$_SESSION['fname']?> dans Camagru</p>
<p>Merci de valider ton adresse email</p>
<a href="<?=$base_url.'/login/send_confirm_email'?>">Me ré-envoyer le mail</a>
<a href="<?=$base_url?>profil">Changer mon adresse email</a>
</div>
