<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Gnote.
 *
 * Gnote is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with Gnote. If not, see <http://www.gnu.org/licenses/>
 * ========================================================================
 */

//Initialisation de la session
session_start() ;

$chemin = $_SERVER['PHP_SELF'];
$fichier = explode('/', $chemin);
$fichier = array_pop($fichier);

if ($fichier == 'auth.php')
{
	include("lang/".$fichier);
}
else
{
	include("../lang/".$fichier);
}

//Inclusions des fichiers
require_once("func.php");
require_once("config.php");

//Connexion sql
@mysql_connect($dbhote, $dbuser, $dbpass) or die('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" ><head><title>Identifiez vous...</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link type="text/css" href="style/style.css" rel="stylesheet" /></head><body class="identification"><form method="post" action="auth.php" class="identification"><div class="top_msg_error"><p class="icon_error">Oups ... erreur critique</p></div><div class="contenuform"><p class="infoform">Il est impossible de se connecter à la base de données.<br /><br />Vous pouvez tenter de rafraichir la page.<br /><br />Si le problème persiste, vous avez la possibilité de contacter l\'administrateur de l\'application Gnote.</p></div><p class="bottomform"><input type="button" value="Actualiser" ONCLICK="location.reload()"></p></form></body></html>' ); // Connexion à MySQL

@mysql_select_db($dbbase); // Sélection de la base

//Uniquement à partir de PHP 5.2.3
//mysql_set_charset('utf8');
mysql_query("set names 'utf8';"); //Définition de l'utf8 comme jeu de caractères

?>
