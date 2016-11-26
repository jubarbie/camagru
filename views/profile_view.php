<div class="container">
	<h1>Informations du profil</h1>
	<form id="login" action="<?=$base_url?>user" method="post">
		<label for="lname">Nom</label>
		<input type="text" value="<?=$lname?>" name="lname" id="lname" />
		<label for="fname">Prénom</label>
		<input type="text" value="<?=$fname?>" name="fname" id="fname" />
		<label for="email">Email</label>
		<input type="text" value="<?=$email?>" name="email" id="email" />
		<input type="submit" value="Mettre à jour" name="submit" />
		<a href="<?=$base_url?>user/change_pwd">Changer le mot de passe</a>
	</form>
</div>
