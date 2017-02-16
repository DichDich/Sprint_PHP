<?php
if($action =='AddRest')
{
    $restList = T_e_restaurant_res::findAll();
    if(isset($_POST['submit']))
    {
        $etatAjout = 1;
        foreach ($restList as $unResto) 
        {
            if($_POST["res_nom"] == $unResto->res_nom)
            {
                $etatAjout = 0;
                $_SESSION["listeErreur"][] = "Ce restaurant existe deja !";
            }
        }              
        if(filter_var($_POST["res_mel"], FILTER_VALIDATE_EMAIL) == false)
        {
            $_SESSION["listeErreur"][] = "Format mail invalide !";
            $etatAjout = 0;
        }                
        if(strlen($_POST["res_tel"]) > 10)
        {
            $_SESSION["listeErreur"][] = "Format numéro de téléphone invalide !";
            $etatAjout = 0;
        }
        if(filter_var($_POST["res_categorieprix_min"], FILTER_SANITIZE_NUMBER_INT) == false || filter_var($_POST["res_categorieprix_max"], FILTER_SANITIZE_NUMBER_INT) == false)
        {
            $_SESSION["listeErreur"][] = "Mauvais format pour la categorie de prix !";
            $etatAjout = 0;
        }
        if($_POST["res_categorieprix_min"] > $_POST["res_categorieprix_max"])
        {
            $_SESSION["listeErreur"][] = "La catégorie de prix min doit être inférieure à la catégorie de prix max !";
            $etatAjout = 0;
        }
        if($etatAjout==1)
        {
            $unRestaurant = new T_e_restaurant_res();
            foreach($_POST as $attribName => $value)
            {
                
                if($attribName == "res_categorieprix_min")
                        $unRestaurant->res_categorieprix = $_POST["res_categorieprix_min"]." € - ".$_POST["res_categorieprix_max"]." €";
                if(in_array($attribName, array_keys($unRestaurant->getAttrs())))
                {
                    $unRestaurant->$attribName = $_POST[$attribName];
                }
                
            }
			$_SESSION["listeSucces"][] = "Restaurant ajouté avec succès !";
            render('accueil');		
        }
        else
        {
            render('addRest');
        }
    }
    else
    {
        render("addRest");
    }
}


if($action=="recherche")
{
    $restList = T_e_restaurant_res::findAll(); 
    if(isset($_POST["valide"]))
    {
        //-------------FILTRE----------
            //-----TYPE CUISINE-----
        if($_POST['type_cuisine']!="-")
        {
            $restList = T_j_cuisineresto_cur::restoTypeCui($_POST['type_cuisine']);
        }

        //-------------TRI-----------
        //-----PRIX-----
        if($_POST["valide"]=="Trier par prix")
        {
            if(isset($_POST['triPrix']))
            {
                $restList = trier($restList, "prx_prix", $_POST['triPrix']);
            }
        }
        //---------NOM---------
        if($_POST["valide"]=="Trier par nom")
        {
            if(isset($_POST['triPrix']))
            {
                $restList = trier($restList, "res_nom", $_POST['triPrix']);
            }
        }

        if(empty($_POST['recherche']))
        {
            //print_r($restList);
            $data = $restList;
        }
        else
        {
            $recherche = strtolower($_POST["recherche"]);
            $recherche = str_replace("-", " ", $_POST['recherche']);
            $recherche = str_replace("é", "e", $recherche);
            //-------VERIFICATION---------
            foreach ($restList as $unResto) 
            {

                $nomResto = strtolower(str_replace("-", " ", $unResto->res_nom));
                $nomResto = str_replace("é", "e", $nomResto);
                $nomVille = strtolower(str_replace("-", " ", $unResto->res_ville));
                $nomVille = str_replace("é", "e", $nomVille);
                $filtreNom = strstr($nomResto, $recherche);
                $filtreVille = strstr($nomVille, $recherche);

                if($_POST['type_cuisine']!="-")
                {
                    if($filtreNom || $filtreVille){
                        $data[] = $unResto;
                    }
                }
                else
                {
                    if($filtreNom || $filtreVille){
                        $data[] = $unResto;
                    }
                }
            }

        }
        render("resultatRecherche");
    }
    else
    {
        render("accueil");
    }
    
}

if($action=="detail")
{
    if($action=="detail")
    {
        if(isset($_POST['ajoutReponse'])){
            T_e_avis_avi::ajoutReponse($_POST['avi_id'], $_POST['avi_reponserestaurateur']);
        }

        if(isset($_POST['valideReserv'])){
            if(empty($_POST['plageH'])){
                $_SESSION["listeErreur"][] = "Veuillez choisir une reservation";
            }else{
                T_j_reservation_rst::insertReserv($_POST['res_id'], $_POST['plageH']);
                $_SESSION["listeSucces"][] = "Votre reservation a été prise en compte";
            }
        }

        if(isset($_GET['id']))
        {
            $url = "r=".$route."&&id=".$_GET['id'];

            if(isset($_POST["valide"]) && $_POST["valide"]=="Trier par langue")
            {
                if($_POST["triLangue"]=="English" || $_POST["triLangue"]=="French"){
                    $listAvis = T_e_avis_avi::avistriLangue($_POST['triLangue'], $_GET["id"]);
                }
                else{
                    $listAvis = T_e_avis_avi::listAvisResto($_GET["id"]);
                }
            }
            else{
                $listAvis = T_e_avis_avi::listAvisResto($_GET["id"]);
            }

            if(isset($_POST["valide"]) && $_POST["valide"]=="Trier par date")
            {
                if(isset($_POST['triDate']) && $_POST['triDate']=="decroissant")
                {
                    usort($listAvis, function($a, $b)
                    {
                        if ($a->avi_date == $b->avi_date)
                            return 0;
                        else if ($a->avi_date > $b->avi_date)
                            return -1;
                        else              
                            return 1;
                    });
                }
                else
                {
                    usort($listAvis, function($a, $b)
                    {
                        if ($a->avi_date == $b->avi_date)
                            return 0;
                        else if ($a->avi_date < $b->avi_date)
                            return -1;
                        else
                            return 1;
                    });

                }
            }
            if(isset($_POST["valide"])&&$_POST["valide"]=="Trier par note")
            {
                if(isset($_POST['triDate'])&&$_POST['triDate']=="decroissant")
                {
                    usort($listAvis, function($a, $b)
                    {
                        if ($a->avi_noteglobale == $b->avi_noteglobale)
                            return 0;
                        else if ($a->avi_noteglobale > $b->avi_noteglobale)
                            return -1;
                        else              
                            return 1;
                    });
                }
                else
                {
                    usort($listAvis, function($a, $b)
                    {
                        if ($a->avi_noteglobale == $b->avi_noteglobale)
                            return 0;
                        else if ($a->avi_noteglobale < $b->avi_noteglobale)
                            return -1;
                        else
                            return 1;
                    });

                }
            }

            $data = new T_e_restaurant_res($_GET["id"]);
            render('detailsRest');
        }
    }
}

if($action=="addPhoto")
{
    if($action=="addPhoto")
    {
        $data = new T_e_restaurant_res($_GET["id"]);

        $uploaddir = './upload/';

        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
        $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
        $extension_upload = strtolower(  substr(  strrchr($_FILES['userfile']['name'], '.')  ,1)  );
        if ( !in_array($extension_upload,$extensions_valides) ) 
        {
            $_SESSION["listeErreur"][] = "Mauvaise extension de fichier ! ";
            render('detailsRest');
        }
        else
        {
            echo '<pre>';
            if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) 
            {
                $_SESSION["listeErreur"][] = "Votre photo n'a pas été ajoutée";
            }
            else
            {
                $listeSucces[] = "Votre photo a été ajouté avec succès";
            }

            T_e_photo_pho::insertImg($uploadfile, $_POST['res_id']);
            echo '</pre>';
            render('detailsRest');
        }
    }
}
if($action=="addAvis")
{
    if($action=="addAvis")
    {
        $unAvis = new T_e_avis_avi();
        foreach($_POST as $attribName => $value)
        {
            if(in_array($attribName, array_keys($unAvis->getAttrs())))
            {
                if($attribName != "avi_platsconseilles" || $_POST['avi_platsconseilles'] != "")
                    $unAvis->$attribName = $_POST[$attribName];
            }
        }

        $listAvis = T_e_avis_avi::listAvisResto($_POST['res_id']);

        $data = new T_e_restaurant_res($_POST['res_id']);
        render('detailsRest');
    }
}

function trier($list, $attr, $val)
{
	if($val=="decroissant")
    {
		usort($list, function($a, $b) use ($attr)
		{
		    if ($a->$attr == $b->$attr)
		        return 0;
		    else if ($a->$attr > $b->$attr)
		        return -1;
		    else              
		        return 1;
		});
	}
	if($val=="croissant")
    {
		usort($list, function($a, $b) use ($attr)
		{
		    if ($a->$attr == $b->$attr)
		        return 0;
		    else if ($a->$attr < $b->$attr)
		        return -1;
			else
		    	return 1;
		});
	}
	return $list;
}
