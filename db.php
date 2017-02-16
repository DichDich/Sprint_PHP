<?php	
// Connexion a la base 
$db = new PDO("pgsql:host=localhost;dbname=colasd ; port=5433","colasd_sprint","DAmAs2");

// Définis la variable globale db
function db() {
	global $db;
	return $db;
}
