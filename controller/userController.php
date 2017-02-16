<?php
if($action=="profil")
{
    foreach (T_e_abonne_abo::findAll() as $unAbo) 
    {
        if($unAbo->abo_id==$_GET['id'])
        {
            $data = $unAbo;
            render("detailsProfil");
        }
    }
}

if($action=="monProfil")
{
    foreach (T_e_abonne_abo::findAll() as $unAbo) 
    {
        if($unAbo->abo_id==$_SESSION['idCo'])
        {
            $data = $unAbo;
            render("detailsProfil");
        }
    }
}
if($action=="favoris")
{
    render('favoris');
}
if($action=="addFav")
{
    T_j_favori_fav::ajoutFav($_SESSION['idCo'], $_GET['id']);
    $listFavoris = T_j_favori_fav::listResFav($_SESSION['idCo']);
    $data = new T_e_restaurant_res($_GET["id"]);
    render('detailsRest');
}

if($action=="supprFav")
{
    T_j_favori_fav::supprFav($_SESSION['idCo'], $_GET['id']);
    $listFavoris = T_j_favori_fav::listResFav($_SESSION['idCo']);
    $data = new T_e_restaurant_res($_GET["id"]);
    if($_POST['valide']=="Supprimer")
    {
        render('favoris');
    }
    elseif($_POST['valide']=="Supprimer de mes favoris")
    {
        render('detailsRest');
    }
}

//------MODIFICATION PROFIL-------------------
if($action == 'modifPro')
{
    if(isset($_POST["valide"]))
    {
        $etatAjout = 1;
        foreach ($listeAbonne as $unAbo) 
        {
            if($unAbo->abo_id != $_SESSION['idCo'])
            {
                if($unAbo->abo_mel==$_POST['abo_mel'])
                {
                    $_SESSION["listeErreur"][] = "Email existant, veuillez saisir un autre email !";
                    $etatAjout = false;;
                }
            }

        }
        if(entryTest($_POST) && $etatAjout)
        {         
            $_SESSION["listeSucces"][] = "Modification réalisée avec succes !";          
            $unAbonnee = new T_e_abonne_abo($_SESSION['idCo']);
            foreach($_POST as $attribName => $value)
            {
                if(in_array($attribName, array_keys($unAbonnee->getAttrs())))
                {

                        $unAbonnee->$attribName = $_POST[$attribName];
                }
            }
            render("formUpdtProfil");
        }
        else
        {
            render("formUpdtProfil");
        }
        //Ref Unused code
    }
    else
    {
        render("formUpdtProfil");
    }
}
//----------INSCRIPTION---------------
if($action == "inscription")
{
    if(isset($_POST["valide"]))
    {
        $etatAjout = true;
        foreach (T_e_abonne_abo::findAll() as $unAbo) 
        {
            if($unAbo->abo_pseudo==$_POST['abo_pseudo'])
            {
                $_SESSION["listeErreur"][] = "Pseudo deja pris !";
                $etatAjout = false;
            }
            if($unAbo->abo_mel==$_POST['abo_mel'])
            {
                $_SESSION["listeErreur"][] = "Email existant, veuillez saisir un autre email !";
                $etatAjout = false;
            }
        }
        if(checkMdp($_POST))
        {
            $_SESSION["listeErreur"][] = "Les mots de passe de correspondent pas !";
            $etatAjout = false;
        }                
        if(entryTest($_POST) && $etatAjout)
        {
            $unAbonnee = new T_e_abonne_abo();
            foreach($_POST as $attribName => $value)
            {
                if(in_array($attribName, array_keys($unAbonnee->getAttrs())))
                {

                        $unAbonnee->$attribName = $_POST[$attribName];
                }
            }

            $_SESSION['etatConnexion'] = 1;
            $_SESSION['idCo'] = $unAbonnee->abo_id;

            render('accueil');
        }
        else
        {
            render('formInscription');
        }
    }
    else
    {
        render('formInscription');
    }
}
//------------CONNEXION---------------------
if($action == "connexion")
{
    if(isset($_POST['valideForm']))
    {
        $etatConnexion = 0;
        foreach (T_e_abonne_abo::findAll() as $unAbo)
        {
            if($_POST['identifiant']==$unAbo->abo_mel || $_POST['identifiant']==$unAbo->abo_pseudo)
            {
                if($_POST['password']==$unAbo->abo_motpasse)
                {
                    $etatConnexion = 1;
                    $_SESSION['idCo'] = $unAbo->abo_id;
                    echo "<script> connexion();</script>";
                }
            }
        }
        if($etatConnexion == 1)
        {
            $_SESSION['etatConnexion'] = 1;
            render('accueil');
        }
        else if($etatConnexion == 0)
        {
            $_SESSION["listeErreur"][] = "Mauvais identifiant ou mot de passe !!";
            render('formConnexion');
        }
        else
        {
            render('formConnexion');
        }
    }
    else
    {
        render("formConnexion");
    }	
}

if($action == "deco")
{
    unset($_SESSION['etatConnexion']);
    unset($_SESSION['idCo']);
    render('accueil');
}

function entryTest($entries)
{
    $entriesValidation = true;           
    if(filter_var($entries["abo_mel"], FILTER_VALIDATE_EMAIL) == false)
    {
        $_SESSION["listeErreur"][] = "Format mail invalide !";
        $entriesValidation = false;
    }                
    if(filter_var($entries["abo_tel"], FILTER_SANITIZE_NUMBER_INT) == false || strlen($entries["abo_tel"]) > 10)
    {
        $_SESSION["listeErreur"][] = "Format numéro de téléphone invalide !";
        $entriesValidation = false;
    }
    return $entriesValidation;
}

function checkMdp($formData)
{
    foreach($formData as $fieldName => $value)
    {
        if($fieldName == "abo_motpasse")
            if($value != $formData["confirmation_motpasse"])
            {
                echo $formData["confirmation_motpasse"] . " " . $value;
                return true;
            }
    }
}
?>