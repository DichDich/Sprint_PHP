<?php 

	if(!empty($_SESSION["listeErreur"])){
		echo "<div class='erreur'><ul>";
		foreach ($_SESSION["listeErreur"] as $k => $uneErreur) {
			echo "<li>".$uneErreur;
		}
		echo "</ul></div>";
        unset($_SESSION["listeErreur"]);
	}
	if(!empty($_SESSION["listeSucces"])){
		echo "<div class='succes'><ul>";
		foreach ($_SESSION["listeSucces"] as $k => $unSucces) {
			echo "<li>".$unSucces;
		}
		echo "</ul></div>";
        unset($_SESSION["listeSucces"]);
	}

?>

<h1><?php echo $data->res_nom; ?></h1>

<?php
if(isset($_SESSION['etatConnexion']))
{
	$etatFav = 0;
	foreach ($listFavoris as $unFav) 
	{
		if($unFav->res_id==$data->res_id)
		{
			$etatFav = 1;
		}
	}
	if($etatFav==0)
	{
		?>
		<form method="post" <?php echo "action='.?r=user/addFav&&id=".$data->res_id."'"?> >
  			<input type="submit" value="Ajouter à mes favoris" />
		</form>
		<?php
	}else
	{
		?>
		<form  method="post" <?php echo "action='.?r=user/supprFav&&id=".$data->res_id."'"?> >
  			<input type="submit" name="valide" value="Supprimer de mes favoris" />
		</form>
		<?php
	}
}
?>

<div class="detailsRestt">
	<p>Se situe : <?php echo $data->res_adrligne1.", ".$data->res_ville.", ".$data->res_cp; ?></p>
	<p>Prix : <?php echo $data->res_categorieprix; ?></p>
	<p>Telephone : <?php echo $data->res_tel; ?></p>
	<p>Mail : <?php echo $data->res_mel; ?></p>
	<?php 
		if(strlen($data->res_siteweb)>0)
		{
			echo "<p>Site web : <a href='".$data->res_siteweb."'>".$data->res_siteweb."</a></p>";
		}
	?>
	<h3>Description</h3>
	<p><?php echo $data->res_description; ?></p>
	<div id="optDetail">
		<span id="Avis">Avis</span><span id="Photo">Photo</span><span id="Reservation">Réservation</span>
	</div>
	<div id="element">
		<div class="hidden" id="Photo">
			<h3>Ajouter une photo</h3>

				<form <?php echo "action='.?r=rest/addPhoto&&id=".$data->res_id."'"?> method="post" enctype="multipart/form-data">
				    Envoyez ce fichier : <input name="userfile" type="file" accept="image/*" />
		  			<input type="submit" value="Envoyer le fichier" />
		  			<?php 
						echo "<input type='text' name='res_id' id='res_id' value='" . $data->res_id . "' hidden />"; 
					?>
				</form>

			<h3>Photos</h3>

			    <?php
                    $test = false;
                    foreach (T_e_photo_pho::findAll() as $unePhoto) 
                    {
						if($data->res_id==$unePhoto->res_id)
                        {
                            echo "<img src='./".$unePhoto->pho_url."' id='imgResto' width='250' height='160'>";
                            $test = true;
                        }
					}
                    if($test == false)
                    {
                         echo "Aucune photo";
                    }
				?>

		</div>
		<div class="active" id="Avis">
			<!--Etre connecte pour deposer un avis -->
			<?php 
			if(isset($_SESSION['etatConnexion'])) 
			{ 
			?>
			<form action=".?r=rest/addAvis" method="post" id="formAvis">
				<p id="title">Déposer un avis</p>

				<?php 
					echo "<input type='text' name='abo_id' id='abo_id' value='". $_SESSION['idCo']."'' hidden />";
					echo "<input type='text' name='res_id' id='res_id' value='" . $data->res_id . "' hidden />"; 
				?>

				<label for="note">Note globale :</label>
				<input type="number" name="avi_noteglobale" id="avi_noteglobale" min="1" max="5" value="3" required><span id="noteMax"> / 5</span><br><br>
				<label for="titre">Titre :</label>
				<input type="text" name="avi_titre" id="avi_titre" value="" required><br><br>
				<label for="message">Votre avis :</label>
				<textarea name="avi_detail" id="avi_detail" placeholder="Ecrivez votre message ici..." required></textarea>
				<label for="periode">Période de visite :</label>
				<select name='per_id'>
							<?php
								$monthArray = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
								foreach(T_r_periodevisite_per::findAll() as $object)
									{
										echo "<option value='" . $object->per_id . "'>" . $monthArray[$object->per_mois - 1] . " " . $object->per_annee . "</option>";
									}
								?>
					</select><br><br>
				<label for="periode">Type de repas :</label>
				<select name='rep_id'>
					<?php
						foreach(T_r_typerepas_rep::findAll() as $object)
							{
								echo "<option value='" . $object->rep_id . "'>" . $object->rep_libelle . "</option>";
							}
					?>
				</select><br><br>
				<label for="titre">Quel(s) plat(s) conseillez-vous ? :</label>
				<input type="text" name="avi_platsconseilles" id="avi_platsconseilles" value=""><br><br>
				<input type="submit" name="addAvis" id="addAvis" value="Envoyer">	
			</form>
			<?php } ?>
				<div id="listAvis">
					
					<div id="headerAvis">
						<form <?php echo "action='.?".$url."'"; ?> method="post" id="triDate">
							<select name='triDate'>
								<?php
									if(isset($_POST['triDate'])&&$_POST['triDate']=="decroissant")
									{
										echo "<option value='decroissant'>Décroissant</option>";
										echo "<option value='croissant'>Croissant</option>";
									}
									else
									{
										echo "<option value='croissant'>Croissant</option>";
										echo "<option value='decroissant'>Décroissant</option>";
									}
								?>
							</select><br><br>
							<input type='submit' name='valide' value='Trier par date'>
							<input type='submit' name='valide' value='Trier par note'>
						</form>
						</br>
						<p id="addFiltre">+ Ajouter un filtre</p>
						<form <?php echo "action='.?".$url."'"; ?> method="post" id="triLangue" style="display: none;">
						<select name='triLangue'>
						<?php
									if(isset($_POST['triLangue']) && $_POST['triLangue']=="French")
									{
										echo "<option value='French'>Français</option>";
										echo "<option value='English'>Anglais</option>";
										echo "<option value='toute'>Toutes</option>";
									}
									elseif(isset($_POST['triLangue'])&&$_POST['triLangue']=="English")
									{
										echo "<option value='English'>Anglais</option>";
										echo "<option value='French'>Français</option>";
										echo "<option value='toute'>Toutes</option>";
									}
									else
									{
										echo "<option value='toute'>Toutes</option>";
										echo "<option value='English'>Anglais</option>";
										echo "<option value='French'>Français</option>";
									}
								?>
						</select><br><br>
						<input type='submit' name='valide' value='Trier par langue'>
						</form>
					</div>
			 <?php if(!empty($listAvis)){
				 	foreach ($listAvis as $unAvis) 
				 	{
				 		echo "<div class='unAvis'>";
				 		echo "<h4>".$unAvis->avi_noteglobale."/5 - ".$unAvis->avi_titre."</h4>";
				 		list($annee, $mois, $jour) = explode('-', $unAvis->avi_date);
				 		foreach ($listeAbonne as $unAbo) 
				 		{
				 			if($unAbo->abo_id==$unAvis->abo_id)
				 			{
				 				echo "<p>Publié par <a class='infoAvis' href='.?r=user/profil&&id=".$unAbo->abo_id."'>".$unAbo->abo_pseudo."</a> le ".$jour."/".$mois."/".$annee."</p>";
				 			}
				 		}
				 		foreach (T_r_typerepas_rep::findAll() as $unType) {
				 			if($unType->rep_id==$unAvis->rep_id){
				 				echo "Type de repas : ".$unType->rep_libelle;
				 			}
				 		}
				 		echo "<p>".$unAvis->avi_detail."</p>";
				 		if($unAvis->avi_platsconseilles!=null)
				 		{
				 			echo "<p>Vous conseil : ".$unAvis->avi_platsconseilles."</p>";
				 		}
				 		if($unAvis->avi_reponserestaurateur!=null)
				 		{	
				 			echo "<p class='reponseAvis'><span class='rep'>Le restaurateur a répondu :</span><br>".$unAvis->avi_reponserestaurateur."</p>";
				 		}
				 		else
				 		{
					 		?>

					 		<div id="reponseAvis">
					 		<h4>Répondre à l'avis :</h4>
					 			<form action="#" method="post">
					 				<textarea name="avi_reponserestaurateur" cols="5" rows="3"></textarea><br>
					 				<input type="submit" name="ajoutReponse">
					 				<?php 
										echo "<input type='text' name='avi_id' id='avi_id' value='".$unAvis->avi_id."' hidden />"; 
									?>
					 			</form>
					 		</div>

					 		<?php
				 		}
				 		echo "</div>";
				 	}
			 	}
			 	else{
			 		echo "Aucun avis sur ce restaurant";
			 	}
			  ?>
			</div>
		</div>
		<div class="hidden" id="Reservation">
		<h3>Vous pouvez reservez pour le dejeuner de demain</h3>
		<p>Choisissez votre horaire :</p>
			<?php
				foreach (T_r_plagehoraire_phr::allPlage() as $unePlageH){
					$etat = 0;
					foreach (T_j_reservation_rst::allReserv($data->res_id) as $uneReserv) {
						if($unePlageH==$uneReserv->phr_plage){
							$etat=1;
						}
					}
					if($etat!=1){
						echo "<button id='".$unePlageH."'>".$unePlageH."</button>";
					}
					else{
						echo "<button id='occuped'>".$unePlageH."</button>";
					}
				}
			?>
			<br><br>
			<form method='post' action='#' >
				<?php echo "<input type='text' name='res_id' id='res_id' value='" . $data->res_id . "' hidden />"; ?>
				<input type="texte" id="plageH" name="plageH" readonly>
				<input type="submit" name="valideReserv" value="Valider">
			</form>
		</div>
	</div>
</div>