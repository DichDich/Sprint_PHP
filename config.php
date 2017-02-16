<?php

// Gère les erreurs
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', true);

// Chargement des classes
function loadMyClass($className) 
{
	include_once "model/" . $className .".php";
}
spl_autoload_register('loadMyClass');