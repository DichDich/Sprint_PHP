<div class="divConnexion">
<?php 

	if(!empty($_SESSION["listeErreur"])){
		echo "<div class='erreur'><ul>";
		foreach ($_SESSION["listeErreur"] as $k => $uneErreur) {
			echo "<li>".$uneErreur;
		}
		echo "</ul></div>";
        unset($_SESSION["listeErreur"]);
	}

?>
	<h3 class="sous-titre">Connexion</h3>
	<form action=".?r=user/connexion" method="post" id="formConnexion"/>
		<label for="identifiant">Identifiant : </label>
		<input type="text" name="identifiant" id="identifiant" required/>
		<br><br>
		<label for="password">Mot de passe : </label>
		<input type="password" name="password" id="password" required/>
		</br>
		<input type="submit" name="valideForm" value="Login" />
	</form>
</div>

