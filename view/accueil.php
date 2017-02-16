<?php 

	if(!empty($_SESSION["listeErreur"]))
	{
		echo "<div class='erreur'><ul>";
		foreach ($_SESSION["listeErreur"] as $k => $uneErreur) 
		{
			echo "<li>".$uneErreur;
		}
		echo "</ul></div>";
        unset($_SESSION["listeErreur"]);
	}
	if(!empty($_SESSION["listeSucces"]))
	{
		echo "<div class='succes'><ul>";
		foreach ($_SESSION["listeSucces"] as $k => $unSucces) 
		{
			echo "<li>".$unSucces;
		}
		echo "</ul></div>";
        unset($_SESSION["listeSucces"]);
	}

?>

<div class="divRecherche">
	<h3 class="sous-titre">Trouvez le restaurant parfait...</h3>
	<form action="?r=rest/recherche" method="post" id="formRecherche">
		<div id="Recherche">
			<input type="text" id="recherche" name="recherche" value="" class="bouton-recherche-text">
			<input type="submit" id="valide" name="valide" value="Recherche" class="bouton-recherche-submit">
		</div>
		<p id="addFiltre">+ Ajouter un filtre</p>
		<div id="filtre" style="display:none">
			<label for=""></label>
			<select name="type_cuisine">
				<option value="-">Type cuisine</option>
				<?php
					foreach ($listeTypeCuisine as $unTypeCui) {
						echo "<option value='".$unTypeCui->cui_id."'>".$unTypeCui->cui_libelle."</option>";
					}
				?>
			</select>
		</div>
	</form>
</div>