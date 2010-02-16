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

function get_microtime()
{
	list($tps_usec, $tps_sec) = explode(" ",microtime());
	return ((float)$tps_usec + (float)$tps_sec);
}

$GLOBALS['tps_start'] = get_microtime();

function datefr()
{
	$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");

	$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

	$datefr = $jour[date("w")]." ".date("d")." ".$mois[date("n")]." ".date("Y");

	return "Nous sommes le ". $datefr;
}

function db_query($sql)
{
	global $nb_requete;
	$nb_requete++;
	return mysql_query($sql);

}


function printHead($title, $auth, $param, $dbprefixe)
{
	$datefr = datefr();

	echo'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
		<head>
			<title>Gnote | ' . $title . '</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link type="text/css" href="../style/style.css" rel="stylesheet" />
			<link type="text/css" href="../style/modalbox.css" rel="stylesheet" />
			<link rel="icon" type="image/png" href="../style/img/logo.png" />
			<script type="text/javascript" src="../library/js/prototype.js"></script>
			<script type="text/javascript" src="../library/js/scriptaculous.js?load=builder,effects"></script>
			<script type="text/javascript" src="../library/js/modalbox.js"></script>
		</head>' . "\n";

	if (isset($auth))
	{
		if($auth = 'auth')
		{
			if ( !isset( $_SESSION['pseudo'] ))
			{
				header('Refresh: 0; url=auth.php');
				exit();
			}
		}
	}
	if (!empty($param))
	{
		if($param = 'ifconnectfail')
		{
			if ($_SESSION['derniere_connexion_echouee'] == 'oui')
			{
				$pseudo = $_SESSION['pseudo'];
				mysql_query("UPDATE " . $dbprefixe ."enseignant SET connectfail='non' WHERE identifiant='$pseudo'") or die(mysql_error());
				$_SESSION['derniere_connexion_echouee'] = 'non';

				echo'<div id="attention" style="display:none;"><p style="font-size:130%; text-align:justify; margin-left:10px; margin-right:10px;">Il y a eu une ou plusieurs tentatives de connexions &eacute;chou&eacute;es 	&agrave; votre compte depuis votre d&eacute;rni&egrave;re visite. Si vous avez commis une erreur lors de la saisie de votre mot de passe, il n\'y a pas d\'inqui&eacute;tudes &agrave; avoir. Dans le cas contraire, nous vous sugg&eacute;rons de consulter le Journal des connexions de votre compte ...</p><p class="bottomform"><input type="button" value="Consulter le journal des connexions" onClick="window.location=\'moncompte.php\';"> <input type=\'button\' value=\'Fermer\' onclick=\'Modalbox.hide()\' /></p></div>
				<body onLoad="Modalbox.show($(\'attention\'), {title: \'Attention !\', width: 500});">';
			}
		}

	}
	else
	{
		echo'<body>';
	}
		echo'<div id="wrap">
		<div id="en_tete"><img class="logo_entete" src="../style/img/logo.png" alt="logo" />

				<div class="titre_entete">Gnote</div>
				<div class="description_entete">Gestion de r&eacute;sultats scolaires par navigateur<span class ="description_entete" style="font-size:x-small">et bien plus encore !</span></div>

				<div class="info-connect_entete">
					<span style="float:right;">' . $datefr . '</span><br />
					<div style="padding-top:5px;">Bienvenue, ' .$_SESSION['prenomenseignant'] . ' ' . $_SESSION['nomenseignant'] . ' | <a href="../auth.php?logout" style="background-image: url(\'../style/img/deco.png\'); background-repeat: no-repeat; padding-left:20px;"> Se d&eacute;connecter</a></div>
				</div>

			</div>
			<div id="corps" class="clearfix">';



}

function printFooter()
{
	echo'</div>
	</div>
	<div id="footer">';

	$tps_start = $GLOBALS['tps_start'];
	$tps_end = get_microtime();
	$tps = round($tps_end - $tps_start, 4);

	echo "<p style='position:relative; top:7px; left:10px;'>Gnote est distribué sous licence <a href ='http://www.april.org/gnu/gpl_french.html'>GNU/GPL</a>.<br /><a href='http://zolotaya.isa-geek.com/redmine/projects/gnote'>Forge du projet Gnote</a> - <a href='http://zolotaya.isa-geek.com/redmine/projects/gnote/issues/new'>rapporter une anomalie</a></p><div style='float:right; position:relative; bottom:18px; right:10px;'>Page générée en $tps seconde";

		if (!isset ($GLOBALS['nb_requete']))
		{
			echo', aucune requête exécutée.</div>';
		}
		elseif ($GLOBALS['nb_requete'] == 1)
		{
			echo', 1 requête exécutée.</div>';
		}
		else
		{
			echo ', ' . $GLOBALS['nb_requete'] . ' requêtes exécutées.</div>';
		}

	echo'</div>
	</body>
	</html>';
}

?>
