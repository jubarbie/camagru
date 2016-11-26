<div class="container">
	<h1>Changement du mot de passe</h1>
	<form id="login" action="<?=$base_url?>user/change_pwd" method="post">
		<label for="old-pwd">Ancien mot de passe</label>
		<input type="password" value="<?=$lname?>" name="old-pwd" id="old-pwd" />
		<label for="pwd">Nouveau mot de passe</label>
		<input type="password" value="<?=$fname?>" name="pwd" id="pwd" />
		<label for="re-pwd">Retaper le mot de passe</label>
		<input type="password" value="<?=$email?>" name="re-pwd" id="re-pwd" />
		<input type="submit" value="Changer le mot de passe" name="submit" />
	</form>
</div>
