<?php

/*
 * ========================================================================
 * Copyright (C) 2010 Traullé Jean
 *
 * This file is part of Opencomp.
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

// Si le fichier de configuration existe et qu'il n'est pas vide, c'est que Opencomp a été installé avec succès.
$fichierconfig = 'core/config.php';
if(file_exists($fichierconfig) AND filesize($fichierconfig) > 0)
{
	$dossierinstall = 'install/';

	//DONC SI le répertoire install est encore présent ; on oblige l'utilisateur à le supprimer
	if(file_exists($dossierinstall))
	{
		echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" ><head><title>Opencomp | Erreur ...</title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link type="text/css" href="style/style.css" rel="stylesheet" /></head><body class="identification"><form method="post" action="auth.php" class="identification"><div class="top_msg_error"><p class="icon_error">Oups ... répertoire /install présent !</p></div><div class="contenuform"><p class="infoform">Pour pouvoir utiliser Opencomp, vous devez supprimer le répertoire /install de votre serveur.<br /><br />	Après avoir supprimé le répertoire /install, cliquez sur "Actualiser".</p></div><p class="bottomform"><input type="button" value="Actualiser" ONCLICK="location.reload()"></p></form></body></html>';
	}
	//Sinon, tout va bien, l'utilisateur peut s'identifier
	else
	{
		header('Location: auth.php');
	}
}
//Si le fichier config n'est pas présent, on redirige la personne vers l'install
else
{
	header('Location: install/');
}
?>
