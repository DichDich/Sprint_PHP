<h3>Mes favoris :</h3>

<?php
if(!empty($listFavoris)){
	echo "<ul>";
	foreach ($listFavoris as $unFavoris) {
		foreach ($listeRest as $unResto) {
			if($unResto->res_id==$unFavoris->res_id){
				echo "<div id='unFav'>";
				echo "<li><a href='.?r=rest/detail&&id=".$unFavoris->res_id."'>".$unResto->res_nom."</a></li>";
				?>
				<form  method="post" <?php echo "action='.?r=user/supprFav&&id=".$unFavoris->res_id."'"?> >
  				<input type="submit" name="valide" value="Supprimer" />
				</form>
				<?php
				echo "</div>";
			}
		}
	}
	echo "</ul>";
}else{
	echo "<p>Vous n'avez pas de favoris.</p>";
}