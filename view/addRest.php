<h3 class="sous-titre">Vous pouvez ajouter un restaurant ici !</h3>

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

?>

<form action=".?r=rest/AddRest" method="post" id="formCreerResto" name="formResto">
<?php
	$notRequired = Array("res_siteweb", "res_adrligne2", "res_etat");
	$fields = array(
		"res_nom" => "Nom",
		"res_description" => "Description",
		"res_categorieprix" => "Prix",
        "res_tel" => "Numéro de téléphone",
		"res_siteweb" => "Adresse du site web",
		"res_mel" => "E-mail de votre site",
		"res_adrligne1" => "Adresse",
		"res_adrligne2" => "Adresse (suite)",
		"res_cp" => "Code postal",
		"res_ville" => "Ville",
		"res_etat" => "Etat",
		"pay_id" => "Pays");
    
foreach ($fields as $field => $label) 
{
	if($label=="Pays")
    {
		echo "<p>";
		echo "<label for='".$field."'>".$label." :</label>";
		echo "<select name='".$field."'>";
        $Pays = $listePays;
        foreach ($Pays as $unPays) 
        {
            echo "<option value='".$unPays->pay_id."'>".$unPays->pay_nom."</option>";
        }
		echo "</select>";
		echo "</p>";
	}
    else if($field == "res_categorieprix")
    {
        echo "<label>Categorie prix* :</label>";
        echo "<p id='catPrix'>De :<input type='text' id='res_categorieprix' name='res_categorieprix_min' value='' required placeholder='min' />€ à <input type='text'"; 
        echo "id='res_categorieprix' name='res_categorieprix_max' value='' required placeholder='max' />€</p><br>";
        echo "<label>Type prix* :</label>";
        echo "<select name='prx_prix'>";
        foreach ($listeTypePrix as $unTypePrix => $k) 
        {
            echo "<option value='".$k."'>".$k."</option>";
        }
        echo "</select>";
        echo "</p>";
    }
	else
    {
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
	<input type="submit" id="submit" name="submit" value="Valider" />
</form>

</div>