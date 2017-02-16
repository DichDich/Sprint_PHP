<h3 class="sous-titre">Mon profil :</h3>
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
<form action=".?r=user/modifPro" method="post" id="formUpdtProfil" name="formProfil">
<?php
$notRequired = Array("abo_adrligne2", "abo_etat");
$fields = array(
	"abo_pseudo" => "Pseudo",
	"abo_nom" => "Nom",
	"abo_prenom" => "Prenom",
	"abo_mel" => "Mail",
	"abo_adrligne1" => "Adresse ligne 1",
	"abo_adrligne2" => "Adresse ligne 2",
	"abo_cp" => "Code postale",
	"abo_ville" => "Ville",
	"abo_etat" => "Etat",
	"pay_id" => "Pays",
	"abo_tel" => "Telephone",
	//"submit" => "Modifier"
);
$user = new T_e_abonne_abo($_SESSION['idCo']);
//$user = new T_e_abonne_abo(2);
foreach($fields as $field=>$label) { 
	if($label=="Pseudo" or $label=="Nom" or $label=="Prenom"){
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<input type='text' name='".$field."' value='".$user->$field."' readonly ></br>";
		echo "</p>";
	}

	elseif($label=="Pays"){
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<select name='".$field."'>";
		$Pays = $listePays;
		foreach ($Pays as $unPays) {
			if($unPays->pay_id == $user->pay_id)
			{
				$isSelected = "selected";
			}
			else
			{
				$isSelected = "";
			}
			echo "<option value='".$unPays->pay_id."' " . $isSelected . ">".$unPays->pay_nom."</option>";
		}
		echo "</select></br>";
		echo "</p>";
	}
	else
	{
		if(!in_array($field, $notRequired))
		{
			$required = "required";
		}
		else
		{
			$required = "";
		}

		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<input type='text' name='".$field."' id='".$field."' ". $required ." value='" . $user->$field . "'/>";
		echo "</p>";
	}
}
?>
	<input type="submit" name="valide" value="Modifier">
</form>



