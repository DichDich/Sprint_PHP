<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Tripadvisor</title>
	</head>
	<body>
		<header>
			<h1 class="titre">Tripadvisor</h1>
			<nav>
			<a href=".">Accueil</a>
			<?php
			if(!isset($_SESSION['etatConnexion']))
            {
				echo <<<PLOP
				<a href=".?r=user/inscription">S'inscrire</a>
				<a href=".?r=user/connexion">Se connecter</a>
PLOP;
			}
            else
            {
				echo "<a href='.?r=rest/AddRest'>Ajouter restaurant</a>";
				echo "<a href='.?r=user/monProfil' id='right'>Mon profil</a>";
				echo "<a href='.?r=user/favoris'>Mes favoris</a>";
				echo "<a href='.?r=user/deco' id='right'>Se déconnecter</a>";
			}
			?>
				</nav>
				<div id="imageA">
				</div>
		</header>

		<div class="contenu">
