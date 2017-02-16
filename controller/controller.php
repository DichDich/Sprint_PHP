<?php
$listeTypeCuisine = T_r_cuisine_cui::findAll();
$listeAbonne = T_e_abonne_abo::findAll();
$listeTypePrix = T_r_typeprix_prx::listTypePrix();
$listePays = T_r_pays_pay::FindAll();
$listeRest = T_e_restaurant_res::findAll();

if(isset($_SESSION['idCo'])){
	$listFavoris = T_j_favori_fav::listResFav($_SESSION['idCo']);
}



if(isset($_GET['r']))
{

	$route = $_GET['r'];

	list($model, $action) = explode("/",$route);
	
    //Route vers les actions sur restaurant 
	if($model == 'rest')
    {
        include_once("restController.php");
	}
    
    //Route vers les actions sur les utilisateurs
	if($model == "user")
	{
        include_once("userController.php");
	}
}
else
{
	render("accueil");
}

// ##################################################FONCTIONS##################################################

function render($view) 
{
	global $data;
	global $url;
    global $listeAbonne;
	global $listeTypeCuisine;
    global $listeRest;
	global $listAvis;
	global $listeTypePrix;
	global $listFavoris;
    global $listePays;
    global $listeRest;
    
	include_once "view/header.php";
	include_once "view/".$view.".php";
	include_once "view/footer.php";
}

