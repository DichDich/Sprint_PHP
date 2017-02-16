<?php

	echo "<h1>".$data->abo_pseudo."</h1>";
	echo "<div id='infoProfil'>";
	echo "<p>".$data->abo_mel."</p>";
	foreach ($listePays as $unPays) 
    {
		if($data->pay_id==$unPays->pay_id)
        {
			echo "<p>".$data->abo_ville.", ".$unPays->pay_nom."</p>";
		}
	}
	if(isset($_SESSION['idCo']))
    {
		echo "<a href='.?r=user/modifPro' id='right'>Modifier mon profil</a>";
	}
	echo "</div>";
	$listAvisAbo = T_e_avis_avi::listAvisAbo($data->abo_id);
	echo "<h3><span class='nbAvis'>(".count($listAvisAbo).")</span> Les avis :</h3>";
	echo "<div id='avisProfil'>";
	$var = 1;
	foreach ($listAvisAbo as $unAvis) 
    {
		echo $unAvis->avi_noteglobale."/5 - ".$unAvis->avi_titre."<span class='detailAvis' id='avis".$var."'> (+ détail)</span><br>";
		foreach ($listeRest as $unResto) 
        {
			if($unResto->res_id==$unAvis->res_id)
            {
				echo "<a href='.?r=rest/detail&&id=".$unResto->res_id."'>".$unResto->res_nom."</a><br>";
			}
		}
		echo "<div id='contenu'>";
		echo "<p id='avis".$var."' style='display:none;'>".$unAvis->avi_detail."</p><br>";
		echo "</div>";
		$var++;
	}
	echo "</div>";
	echo "<h3><span class='nbAvis'>(".count(T_j_badgeabonne_baa::allBadgeAbo($data->abo_id)).")</span> Mes badges :</h3>";
	echo "<div id='badgeProfil'>";
	echo "<ul>";
	$listeBadge = array();
	foreach (T_r_badge_bad::findAll() as $unBadge) 
    {
		foreach (T_j_badgeabonne_baa::allBadgeAbo($data->abo_id) as $unBadgeAbo) 
        {
			if($unBadgeAbo->bad_id==$unBadge->bad_id)
            {
				$listeBadge[] = $unBadge;
			}
		}
	}
	foreach ($listeBadge as $unBadge) 
    {
		list($libelle, $event) = explode("-", $unBadge->bad_libelle);
		if(strstr($event, "avis"))
        {
			$listAvis[] = $unBadge->bad_libelle;
		}
		if(strstr($event, "photo"))
        {
			$listPhoto[] = $unBadge->bad_libelle;
		}
		if(strstr($event, "vote"))
        {
			$listVote[] = $unBadge->bad_libelle;
		}
		if(strstr($event, "lecteur"))
        {
			$listLecteur[] = $unBadge->bad_libelle;
		}
		if(strstr($event, "Niveau"))
        {
			$listNiveau[] = $unBadge->bad_libelle;
		}
		
	}
	if(isset($listAvis))
    {
		echo "<img src='./images/badge_Contributeur.png'>";
		for ($i=0; $i < count($listAvis); $i++) 
        { 
			if($i==count($listAvis)-1)
				echo "<li id='lastBadge'>".$listAvis[$i]."<br>";
			else
				echo "<li>".$listAvis[$i];
		}
	}
	if(isset($listPhoto))
    {
		echo "<img src='./images/badge_p'>";
		for ($i=0; $i < count($listPhoto); $i++) 
        { 
			if($i==count($listPhoto)-1)
				echo "<li id='lastBadge'>".$listPhoto[$i]."<br>";
			else
				echo "<li>".$listPhoto[$i];
		}
	}
	if(isset($listVote))
    {
		echo "<img src='./images/badge_cu.png'>";
		for ($i=0; $i < count($listVote); $i++) 
        { 
			if($i==count($listVote)-1)
				echo "<li id='lastBadge'>".$listVote[$i]."<br>";
			else
				echo "<li>".$listVote[$i];
		}
	}
	if(isset($listLecteur))
    {
		echo "<img src='./images/badge_lectorat.png'>";
		for ($i=0; $i < count($listLecteur); $i++) 
        { 
			if($i==count($listLecteur)-1)
				echo "<li id='lastBadge'>".$listLecteur[$i]."<br>";
			else
				echo "<li>".$listLecteur[$i];
		}
	}
	if(isset($listNiveau))
    {
		echo "<img src='./images/badge_expert.png'>";
		for ($i=0; $i < count($listNiveau); $i++) 
        { 
			if($i==count($listNiveau)-1)
				echo "<li id='lastBadge'>".$listNiveau[$i]."<br>";
			else
				echo "<li>".$listNiveau[$i];
		}
	}
	echo "</ul>";
	echo "</div>";
?>