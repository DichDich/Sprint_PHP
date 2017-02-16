<div class="inscription">

<h3 class="sous-titre">Création de compte</h3>

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

<form action='.?r=user/inscription' method="post" id="formInscription">
<?php
	$notRequired = Array("abo_adrligne2", "abo_etat");
	$fields = array(
		"abo_pseudo" => "Pseudo",
		"abo_nom" => "Nom",
		"abo_prenom" => "Prénom",
		"abo_motpasse" => "Mot de passe",
        "confirmation_motpasse" => "Confirmation mot de passe",
		"abo_mel" => "Adresse mail",
		"abo_adrligne1" => "Adresse",
		"abo_adrligne2" => "Complément d'adresse",
		"abo_cp" => "Code postal",
		"abo_ville" => "Ville",
		"abo_etat" => "Etat",
		"pay_id" => "Pays",
		"abo_tel" => "Téléphone");
foreach ($fields as $field => $label) {
	if($label=="Pays"){
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<select name='".$field."'>";
		$Pays = $listePays;
		foreach ($Pays as $unPays) {
			if(isset($_POST['pay_id'])){
				if($unPays->pay_id == $_POST['pay_id']){
					$isSelected = "selected";
				}
				else
				{
					$isSelected = "";
				}
			}
			echo "<option value='".$unPays->pay_id."' ".$isSelected.">".$unPays->pay_nom."</option>";
		}
		echo "</select>";
		echo "</p>";
	}
	else if($field == "abo_motpasse" || $field == "confirmation_motpasse")
	{
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<input type=\"password\" name='".$field."' id='".$field."' required/>";
		echo "</p>";
	}
	else{
		if(!in_array($field, $notRequired))
		{
			$required = "required";
			$label .= "*";
		}
		else
		{
			$required = "";
		}
		if(isset($_POST[$field])){
			$value = "value='".$_POST[$field]."'";
		}else{
			$value = "";
		}
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<input type='text' name='".$field."' id='".$field."' ". $required ." ".$value."/>";
		echo "</p>";
	}
}
?>
	<input type="submit" name="valide" value="S'inscrire">
</form>

</div>