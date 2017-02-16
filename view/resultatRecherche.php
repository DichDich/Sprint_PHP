<div class="divRecherche">
	<h3 class="sous-titre">Trouvez le restaurant parfait...</h3>
	<form action="?r=rest/recherche" method="post" id="formRecherche">
		<div id="Recherche">
			<input type="text" id="recherche" name="recherche" <?php if(isset($_POST['recherche'])) echo "value='".$_POST['recherche']."'";?>  class="bouton-recherche-text">
			<input type="submit" id="valide" name="valide" value="Rechercher" class="bouton-recherche-submit">
		</div>
		<p id="addFiltre">+ Ajouter un filtre</p>
		<div id="filtre" style="display:none">
			<label for=""></label>
			<select name="type_cuisine">
				<?php if($_POST['type_cuisine']!="-"){echo "<option value='".$_POST['type_cuisine']."'>";$cui=new T_r_cuisine_cui($_POST['type_cuisine']); echo $cui->cui_libelle."</option>";}else{echo "<option value='-'>Type cuisine</option>";}?>
				<?php
					foreach ($listeTypeCuisine as $unTypeCui) {
						echo "<option value='".$unTypeCui->cui_id."'>".$unTypeCui->cui_libelle."</option>";
					}
				?>
			</select>
		</div>
		<div id="triPrix">
			<select name='triPrix'>
			<?php
				if(isset($_POST['triPrix']) && $_POST['triPrix']=="decroissant")
                {
					echo "<option value='decroissant'>Descroissant</option>";
					echo "<option value='croissant'>Croissant</option>";
				}
				else{
					echo "<option value='croissant'>Croissant</option>";
					echo "<option value='decroissant'>Descroissant</option>";
				}
				?>
			</select><br><br>
			<input type='submit' name='valide' value='Trier par prix'><input type='submit' name='valide' value='Trier par nom'>
		</div>
	</form>
</div>
<div class="divResultat">
	<h3>Résultat de votre recherche :</h3>
	<?php
	$nbResult = count($data);
	echo '<p>'.$nbResult.' resultat(s) pour votre recherche.</p><br>';
	if($nbResult!=0){
		foreach ($data as $unResto) {
			if(strpos($unResto->res_description, " ") === false){
				$description = $unResto->res_description;
			}
			else{
				$description = substr($unResto->res_description, 0, 90-1);
				$description = strripos($description, " ");
				$description = substr($unResto->res_description, 0, $description)."...";
			}
			echo "<div class='unResto' onclick=\"location.href='.?r=rest/detail&&id=".$unResto->res_id."'\">";
			echo "<h3>".$unResto->res_nom."</h3>";
			echo "<p>Se situe :<br>".$unResto->res_ville.", ".$unResto->res_cp."<br>";
			echo $unResto->res_adrligne1."</p>";
			echo "<p>Categorie prix :<br>".$unResto->prx_prix."</p>";
			echo "<p>".$description."</p>";
			echo "";
			echo "</div>";
		}
	}
	?>
</div>